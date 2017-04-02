<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\classschedule\models\ClassSchedule */

$this->title = Yii::t('app', 'Create Class Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Class Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
