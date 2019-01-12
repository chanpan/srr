<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Slideimg */

$this->title = Yii::t('section', 'Update {modelClass}: ', [
    'modelClass' => 'Slideimg',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('section', 'Slideimgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slideimg-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
