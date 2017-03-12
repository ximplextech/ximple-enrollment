<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\schoolyear\models\Schoolyear */

$this->title = Yii::t('app', 'Create School Year');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schoolyear-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
