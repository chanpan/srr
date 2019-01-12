<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ExampleData */

$this->title = Yii::t('section', 'Update {modelClass}: ', [
    'modelClass' => 'Example Data',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('section', 'Example Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="example-data-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
