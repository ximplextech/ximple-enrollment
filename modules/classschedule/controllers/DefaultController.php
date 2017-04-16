<?php

namespace app\modules\classschedule\controllers;

use Yii;
use app\modules\classschedule\models\ClassSchedule;
use app\modules\classschedule\models\ClassScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for ClassSchedule model.
 */
class DefaultController extends Controller {

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
     * Lists all ClassSchedule models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClassScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'model' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClassSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClassSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ClassSchedule();

        if (Yii::$app->request->post()) {
            $modelTemp = \app\modules\classschedule\models\ClassScheduleTemporary::findAll(['created_by' => Yii::$app->user->identity->id]);

            $model->load(Yii::$app->request->post());

            $sql = "INSERT INTO {$model->tableName()} (subject_id, school_year_id, semester_id, professor_id, "
                    . "start_time, end_time, sun, mon, tue, wed, thu, fri, sat, created_by, "
                    . "updated_by, section_id, class_intake_limit, start_date, end_date, room_id)  "
                    . "SELECT '{$model->subject_id}', '{$model->school_year_id}', '{$model->semester_id}', '{$model->professor_id}',"
                    . "start_time, end_time, sun, mon, tue, wed, thu, fri, sat, '{$model->created_by}',"
                    . "'{$model->updated_by}', '{$model->section_id}', '{$model->class_intake_limit}', start_date, "
                    . "end_date, '{$model->room_id}' from " . \app\modules\classschedule\models\ClassScheduleTemporary::tableName() . ";";

            if (Yii::$app->db->createCommand($sql)->execute()) {
                \Yii::$app
                        ->db
                        ->createCommand()
                        ->delete(\app\modules\classschedule\models\ClassScheduleTemporary::tableName())
                        ->execute();
                return $this->redirect(['index'/* , 'id' => Yii::$app->db->getLastInsertID() */]);
            }
        } else {
            $model->class_intake_limit = 60;
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ClassSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->class_schedule_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ClassSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionViewEvents($start = NULL, $end = NULL, $_ = NULL) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $addWhere .= " is_status = 0 ";
        if (Yii::$app->request->post()) {
            $addWhere .= " and school_year_id = '" . Yii::$app->request->post()['school_year_id'] . "'";
            $addWhere .= " and semester_id = '" . Yii::$app->request->post()['semester_id'] . "'";

            if (isset(Yii::$app->request->post()['room_id']) && Yii::$app->request->post()['room_id'] != "") {
                $addWhere .= " and room_id = '" . Yii::$app->request->post()['room_id'] . "'";
            }

            if (isset(Yii::$app->request->post()['professor_id'])  && Yii::$app->request->post()['professor_id'] != "") {
                $addWhere .= " and professor_id = '" . Yii::$app->request->post()['professor_id'] . "'";
            }

//            if (count($addWhereOr) > 0) {
//                $addWhere .= " and " . implode(" or ", $addWhereOr);
//            }
        }



        $eventList = \app\modules\classschedule\models\ClassSchedule::find()->where($addWhere)->all();

        $events = [];

        foreach ($eventList as $event) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $event->class_schedule_id;
            $Event->title = $event->subject->subject_name . " - " . $event->room->room_name .
                    " \n " . Yii::t('app', 'Prof.') . " " . $event->professor->empName;
            $Event->description = $event->subject->subject_name . " - " . $event->room->room_name .
                    " \n " . Yii::t('app', 'Prof.') . " " . $event->professor->empName;
            $Event->start = $event->start_time;
            $Event->end = $event->end_time;
            $Event->color = '#00A65A'; //(($event->event_type == 1) ? '#00A65A' : (($event->event_type == 2) ? '#00C0EF' : (($event->event_type == 3) ? '#F39C12' : '#074979')));
            $Event->textColor = '#FFF';
            $Event->borderColor = '#000';
            $Event->event_type = "Class";
            //$Event->event_type = (($event->event_type == 1) ? 'Class' : (($event->event_type == 2) ? 'Important Notice' : (($event->event_type == 3) ? 'Meeting' : 'Messages')));
            $Event->allDay = null; //($event->event_all_day == 1) ? true : false;
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
     * Finds the ClassSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClassSchedule the loaded model
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
