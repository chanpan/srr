<?php
namespace developeruz\db_rbac\views\access;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Links */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('rbac', 'Add Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Role'), 'url' => ['role']];
$this->params['breadcrumbs'][] = Yii::t('db_rbac', 'Новая роль');
?>
<div class="box box-primary">

    <div class="box-header">
        <?= Html::encode($this->title) ?>
    </div>

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
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= Html::label(Yii::t('rbac', 'Role Name')); ?>
                    <?= Html::textInput('name','',['class' => 'form-control']); ?>
                    <?= Yii::t('rbac', '* Role name can not be empty.'); ?>
                </div></div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= Html::label(Yii::t('rbac', 'Description')); ?>
                    <?= Html::textInput('description','', ['class' => 'form-control']); ?>
                </div>
            </div>
        </div>
        
         
        <div class="form-group">
            <?= Html::label(Yii::t('rbac', 'Permission')); ?>
            <?= Html::checkboxList('permissions', null, $permissions, ['separator' => '<br>']); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('rbac', 'Submit'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>