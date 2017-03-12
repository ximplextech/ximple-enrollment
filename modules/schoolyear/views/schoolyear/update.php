<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\schoolyear\models\Schoolyear */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'School Year',
]) . ' ' . $model->school_year_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->school_year_id, 'url' => ['view', 'id' => $model->school_year_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="schoolyear-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
