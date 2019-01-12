<?php
namespace developeruz\db_rbac\views\access;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Links */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('rbac', 'Update Permission: ') . ' ' . $permit->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Permission'), 'url' => ['permission']];
$this->params['breadcrumbs'][] = Yii::t('rbac', 'Permission');
?>
<div class="box box-primary">

    <div class="box-header"><?= Html::encode($this->title) ?></div>

    <div class="box-body">

        <?php
        if (!empty($error)) {
            ?>
            <div class="error-summary">
                <?php
                echo implode('<br>', $error);
                ?>
            </div>
        <?php
        }
        ?>

        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= Html::label(Yii::t('rbac', 'Description')); ?>
            <?= Html::textInput('description', $permit->description, ['class'=>'form-control']); ?>
        </div>

        <div class="form-group">
            <?= Html::label(Yii::t('db_rbac','Permission Name')); ?>
            <?= Html::textInput('name', $permit->name,['class'=>'form-control']); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('rbac', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>