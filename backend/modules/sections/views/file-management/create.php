<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContentChoice */

$this->title = Yii::t('content', 'Create Content Choice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Content Choices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-choice-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
