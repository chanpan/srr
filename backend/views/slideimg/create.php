<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Slideimg */

$this->title = Yii::t('section', 'Create Slideimg');
$this->params['breadcrumbs'][] = ['label' => Yii::t('section', 'Slideimgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slideimg-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
