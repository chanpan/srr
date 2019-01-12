<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\View */

$this->title = Yii::t('content', 'Update {modelClass}: ', [
    'modelClass' => 'View',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Views'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
