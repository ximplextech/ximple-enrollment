<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\room\models\Room */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'building_id')->dropDownList(ArrayHelper::map(app\modules\building\models\Building::find()->all(),'building_id','building_name'),['prompt'=>Yii::t('app', 'Select Building')]); ?>

    <?= $form->field($model, 'room_name')->textInput(['maxlength' => 45]) ?>

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
