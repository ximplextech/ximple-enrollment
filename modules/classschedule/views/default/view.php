<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\classschedule\models\ClassSchedule */

$this->title = $model->class_schedule_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Class Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-schedule-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->class_schedule_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->class_schedule_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-default']); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'class_schedule_id',
            'subject_id',
            'school_year_id',
            'semester_id',
            'professor_id',
            'start_time',
            'end_time',
            'sun',
            'mon',
            'tue',
            'wed',
            'thu',
            'fri',
            'sat',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'section_id',
            'class_intake_limit',
        ],
    ]) ?>

</div>
