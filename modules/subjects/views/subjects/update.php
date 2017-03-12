<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\subjects\models\Subjects */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Subjects',
]) . ' ' . $model->subject_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject_id, 'url' => ['view', 'id' => $model->subject_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="subjects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
