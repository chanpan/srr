<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sitecode */

$this->title = Yii::t('sitecode', 'Create Sitecode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitecode', 'Sitecodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitecode-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
