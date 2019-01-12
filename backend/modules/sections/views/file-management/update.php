<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContentChoice */

$this->title = Yii::t('content', 'Update {modelClass}: ', [
    'modelClass' => 'Content Choice',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Content Choices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-choice-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
