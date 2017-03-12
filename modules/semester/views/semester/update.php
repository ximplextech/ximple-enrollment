<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\semester\models\Semester */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Semester',
]) . ' ' . $model->semester_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Semesters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->semester_id, 'url' => ['view', 'id' => $model->semester_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="semester-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
