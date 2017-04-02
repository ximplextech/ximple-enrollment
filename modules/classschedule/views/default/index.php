<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\classschedule\models\ClassScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Class Schedules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Class Schedule'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'class_schedule_id',
            'subject_id',
            'school_year_id',
            'semester_id',
            'professor_id',
            // 'start_time',
            // 'end_time',
            // 'sun',
            // 'mon',
            // 'tue',
            // 'wed',
            // 'thu',
            // 'fri',
            // 'sat',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'section_id',
            // 'class_intake_limit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
