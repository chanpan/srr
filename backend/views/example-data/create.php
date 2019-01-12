<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ExampleData */

$this->title = Yii::t('section', 'Create Example Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('section', 'Example Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="example-data-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
