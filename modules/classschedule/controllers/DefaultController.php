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
                    'searchModel' => $searchModel,
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
            . "updated_by, section_id, class_intake_limit, start_date, end_date)  "
            . "SELECT '{$model->subject_id}', '{$model->school_year_id}', '{$model->semester_id}', '{$model->professor_id}',"
            . "start_time, end_time, sun, mon, tue, wed, thu, fri, sat, '{$model->created_by}',"
            . "'{$model->updated_by}', '{$model->section_id}', '{$model->class_intake_limit}', start_date, "
            . "end_date from ".\app\modules\classschedule\models\ClassScheduleTemporary::tableName().";";

            if (Yii::$app->db->createCommand($sql)->execute()) {
                \Yii::$app
                        ->db
                        ->createCommand()
                        ->delete(\app\modules\classschedule\models\ClassScheduleTemporary::tableName())
                        ->execute();
                return $this->redirect(['index'/*, 'id' => Yii::$app->db->getLastInsertID()*/]);
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
