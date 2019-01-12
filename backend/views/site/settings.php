<?php

use yii\bootstrap\ActiveForm;
use common\components\keyStorage\FormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\KeyStorageItem */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('backend', 'Application settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-defaut">
    <div class="box-body">
         <?= FormWidget::widget([
            'model' => $model,
            'formClass' => ActiveForm::class,
            'submitText' => Yii::t('backend', 'Save'),
            'submitOptions' => ['class' => 'btn btn-primary'],
        ]) ?>
    </div>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .box-defaut {
         border: none;
         box-shadow: 0px 0px 1px #cacaca;
     }
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>