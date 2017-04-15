<?php

namespace app\modules\classschedule\controllers;

use Yii;
use app\modules\classschedule\models\ClassSchedule;
use app\modules\classschedule\models\ClassScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\widgets\SwitchInput;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ScheduleController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Events model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * 
     */
    public function actionAddEvent($prof_id = NULL) {
        $model = new \app\modules\classschedule\models\ClassScheduleTemporary();
        return $this->renderAjax('_form', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSaveEvents() {

        $model = new \app\modules\classschedule\models\ClassScheduleTemporary();


        if (($model->load(Yii::$app->request->post()) || isset($_POST['ClassScheduleTemporary']))) {

            $model->attributes = $_POST['ClassScheduleTemporary'];
            $model->start_date = new \yii\db\Expression('CURDATE()'); //Yii::$app->dateformatter->storeDateTimeFormat($_POST['ClassScheduleTemporary']['start_date']);
            $model->end_date = new \yii\db\Expression('CURDATE()'); //Yii::$app->dateformatter->storeDateTimeFormat($_POST['ClassScheduleTemporary']['end_date']);
            $model->start_time = Yii::$app->dateformatter->storeTimeFormat($_POST['ClassScheduleTemporary']['start_time']);
            $model->end_time = Yii::$app->dateformatter->storeTimeFormat($_POST['ClassScheduleTemporary']['end_time']);
            $model->created_by = Yii::$app->getid->getId();
            $model->created_at = new \yii\db\Expression('NOW()');
            $model->updated_by = Yii::$app->getid->getId();
            $model->updated_at = new \yii\db\Expression('NOW()');
            //die();
            try {

                if ($model->save(false)) {

                    echo "1";
                }
            } catch (CDbException $ex) {

                if ($ex->getCode() === 23000) {
                    echo "0";
                }
            }
        }
    }

    public function actionLoadEvent($prof_id = NULL) {
        $model = new \app\modules\classschedule\models\ClassScheduleTemporary();
        
        /**
         * Delete Temporary Data
         */
        \Yii::$app
                ->db
                ->createCommand()
                ->delete(\app\modules\classschedule\models\ClassScheduleTemporary::tableName())
                ->execute();
        

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        //$prof_id = Yii::$app->request->post()['prof_id'];
        
        $addWhere .= " where school_year_id = '".Yii::$app->request->post()['school_year_id']."'";
        $addWhere .= " and semester_id = '".Yii::$app->request->post()['semester_id']."'";
        
        if(isset(Yii::$app->request->post()['room_id'])){
            $addWhereOr[] = " room_id = '".Yii::$app->request->post()['room_id']."'";
        }
        
        if(isset(Yii::$app->request->post()['professor_id'])){
           $addWhereOr[] .= " professor_id = '".Yii::$app->request->post()['professor_id']."'";
        }
        
        if(count($addWhereOr) > 0){
            $addWhere .= " and ". implode(" or ", $addWhereOr);
        }
        
        $model->load(Yii::$app->request->post());

        $sql = "INSERT INTO {$model->tableName()} (subject_id, school_year_id, semester_id, professor_id, "
                . "start_time, end_time, sun, mon, tue, wed, thu, fri, sat, created_by, "
                . "updated_by, section_id, class_intake_limit, start_date, end_date, room_id)  "
                . "SELECT subject_id, school_year_id, semester_id, professor_id,"
                . "start_time, end_time, sun, mon, tue, wed, thu, fri, sat, created_by,"
                . "updated_by, section_id, class_intake_limit, start_date, "
                . "end_date, room_id from " . \app\modules\classschedule\models\ClassSchedule::tableName() . ""
                . " {$addWhere};";

        if (Yii::$app->db->createCommand($sql)->execute()) {
            echo "1";
        }else{
            echo "0";
        }
    }

    public function actionViewEvents($start = NULL, $end = NULL, $_ = NULL) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $eventList = \app\modules\classschedule\models\ClassScheduleTemporary::find()->where(['is_status'=> 0])->all();

        $events = [];

        foreach ($eventList as $event) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $event->class_schedule_id;
            $Event->title = $event->subject->subject_name . " - " . $event->room->room_name .
                              " \n ". Yii::t('app', 'Prof.') . " ". $event->professor->empName;
            $Event->description = $event->subject->subject_name . " - " . $event->room->room_name;
            $Event->start = $event->start_time;
            $Event->end = $event->end_time;
            $Event->color = '#00A65A'; //(($event->event_type == 1) ? '#00A65A' : (($event->event_type == 2) ? '#00C0EF' : (($event->event_type == 3) ? '#F39C12' : '#074979')));
            $Event->textColor = '#FFF';
            $Event->borderColor = '#000';
            $Event->event_type = "Class";
            //$Event->event_type = (($event->event_type == 1) ? 'Class' : (($event->event_type == 2) ? 'Important Notice' : (($event->event_type == 3) ? 'Meeting' : 'Messages')));
            $Event->allDay = false; //($event->event_all_day == 1) ? true : false;
            if ($event->sun) {
                $Event->dow[] = 0;
            }
            if ($event->mon) {
                $Event->dow[] = 1;
            }
            if ($event->tue) {
                $Event->dow[] = 2;
            }
            if ($event->wed) {
                $Event->dow[] = 3;
            }
            if ($event->thu) {
                $Event->dow[] = 4;
            }
            if ($event->fri) {
                $Event->dow[] = 5;
            }
            if ($event->sat) {
                $Event->dow[] = 6;
            }

            // $Event->url = $event->event_url;
            $events[] = $Event;
        }
        return $events;
    }

    /**
     * Updates an existing Events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateEvent($event_id) {
        $model = $this->findModel($event_id);
//        if(Yii::$app->request->post()){
//             print_r(Yii::$app->request->post()); die();
//        }
        if ($model->load(Yii::$app->request->post()) || isset($_POST['ClassSchedule'])) {
           
            $model->attributes = $_POST['ClassSchedule'];
            $model->start_date = new \yii\db\Expression('CURDATE()'); //Yii::$app->dateformatter->storeDateTimeFormat($_POST['ClassSchedule']['start_date']);
            $model->end_date = new \yii\db\Expression('CURDATE()'); //Yii::$app->dateformatter->storeDateTimeFormat($_POST['ClassSchedule']['end_date']);
            $model->start_time = Yii::$app->dateformatter->storeTimeFormat($_POST['ClassSchedule']['start_time']);
            $model->end_time = Yii::$app->dateformatter->storeTimeFormat($_POST['ClassSchedule']['end_time']);
            //$model->created_by = Yii::$app->getid->getId();
            //$model->created_at = new \yii\db\Expression('NOW()');
            $model->updated_by = Yii::$app->getid->getId();
            $model->updated_at = new \yii\db\Expression('NOW()');

            try {

                if ($model->save(false)) {

                    return $this->redirect(['/classschedule']);
                }
            } catch (CDbException $ex) {

                if ($ex->getCode() === 23000) {
                    return $this->redirect(['/classschedule']);
                }
            }
        } 
        else {
            return $this->renderAjax('_update_form', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Events model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEventDelete($e_id) {
        $model = ClassSchedule::findOne($e_id);
        $model->is_status = 2;
        $model->updated_by = Yii::$app->getid->getId();
        $model->updated_at = new \yii\db\Expression('NOW()');
        $model->save();

       
        return $this->redirect(['/classschedule']);
    }

    /**
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClassSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
