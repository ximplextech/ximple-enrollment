<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\classschedule\models\ClassSchedule */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Class Schedule',
]) . ' ' . $model->class_schedule_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Class Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->class_schedule_id, 'url' => ['view', 'id' => $model->class_schedule_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="class-schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
