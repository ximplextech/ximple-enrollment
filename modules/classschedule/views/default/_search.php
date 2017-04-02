<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\classschedule\models\ClassScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="class-schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'class_schedule_id') ?>

    <?= $form->field($model, 'subject_id') ?>

    <?= $form->field($model, 'school_year_id') ?>

    <?= $form->field($model, 'semester_id') ?>

    <?= $form->field($model, 'professor_id') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'sun') ?>

    <?php // echo $form->field($model, 'mon') ?>

    <?php // echo $form->field($model, 'tue') ?>

    <?php // echo $form->field($model, 'wed') ?>

    <?php // echo $form->field($model, 'thu') ?>

    <?php // echo $form->field($model, 'fri') ?>

    <?php // echo $form->field($model, 'sat') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'section_id') ?>

    <?php // echo $form->field($model, 'class_intake_limit') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
