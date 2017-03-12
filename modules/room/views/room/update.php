<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\room\models\Room */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Room',
]) . ' ' . $model->room_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->room_id, 'url' => ['view', 'id' => $model->room_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="room-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
