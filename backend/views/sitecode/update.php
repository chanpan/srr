<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sitecode */

$this->title = Yii::t('sitecode', 'Update {modelClass}: ', [
    'modelClass' => 'Sitecode',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitecode', 'Sitecodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitecode-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
