<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Docs */

$this->title = Yii::t('doc', 'Update {modelClass}: ', [
    'modelClass' => 'Docs',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('doc', 'Docs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docs-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
