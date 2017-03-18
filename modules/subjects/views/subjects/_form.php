<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\modules\subjects\models\Subjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subjects-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(\app\modules\course\models\Courses::find()->all(),'course_id','course_code'),['prompt'=>Yii::t('app', 'Select Course')]); ?>
        
    <?= $form->field($model, 'batch_id')->dropDownList(ArrayHelper::map(\app\modules\course\models\Batches::find()->all(),'batch_id','batch_alias'),['prompt'=>Yii::t('app', 'Select Batch')]); ?>

    <?= $form->field($model, 'subject_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), []); ?>
   

    <?php
    /**
     * Hidden inputs
     */
    if($model->isNewRecord){
        
        echo $form->field($model, 'created_by')->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 2])->label(false);
        echo $form->field($model, 'updated_by')->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 2])->label(false);
    
    }else{
        
        echo $form->field($model, 'updated_by')->hiddenInput(['value' => isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 2])->label(false);

    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
