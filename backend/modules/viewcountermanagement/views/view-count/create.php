<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\View */

$this->title = Yii::t('content', 'Create View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Views'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
