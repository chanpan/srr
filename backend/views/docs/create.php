<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Docs */

$this->title = Yii::t('doc', 'Create Docs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('doc', 'Docs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docs-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
