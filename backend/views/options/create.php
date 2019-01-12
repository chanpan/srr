<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Options */

$this->title = Yii::t('options', 'Create Options');
$this->params['breadcrumbs'][] = ['label' => Yii::t('options', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="options-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
