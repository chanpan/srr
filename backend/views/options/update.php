<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Options */

$this->title = Yii::t('options', 'Update {modelClass}: ', [
    'modelClass' => 'Options',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('options', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="options-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
