<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\subjects\models\Subjects */

$this->title = $model->subject_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->subject_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->subject_id], [
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
            'subject_id',
            [
		'attribute'=>'course_id',
		'value'=>(!empty($model->course->course_id) ? $model->course->course_code : "Not Set")
	    ],
            
            [
		'attribute'=>'batch_id',
		'value'=>(!empty($model->batch->batch_id) ? $model->batch->batch_alias : "Not Set")
	    ],
            
            'subject_name',
            'status',
           
            [
		'attribute' => 'created_at',
		'value' => Yii::$app->formatter->asDateTime($model->created_at),
	    ],
            [
		'attribute'=>'created_by',
		'value'=>(!empty($model->createdBy->user_login_id) ? $model->createdBy->user_login_id : "Not Set")
	    ],
	    [
		'attribute' => 'updated_at',
		'value' => ($model->updated_at == null) ? " - ": Yii::$app->formatter->asDateTime($model->updated_at),
	    ],
	    [
		'attribute'=>'updated_by',
		'value'=>(!empty($model->updatedBy->user_login_id) ? $model->updatedBy->user_login_id : "Not Set")
	    ],
        ],
    ]) ?>

</div>
