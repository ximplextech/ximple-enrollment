<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\room\models\Room */

$this->title = $model->room_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->room_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->room_id], [
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
            'room_id',
            'room_name',
            //'building_id',
            [
		'label' => Yii::t('app', 'Building'),
		'attribute' => 'building_id',
		'value' => $model->building->building_name,
 	    ],
            
            //'longitude',
            //'latitude',
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
