<?php
namespace developeruz\db_rbac\views\access;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('rbac', 'Update Role: ') . ' ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Role'), 'url' => ['role']];
$this->params['breadcrumbs'][] = Yii::t('rbac', 'Update Role');
?>
<div class="box box-primary">

    <div class="box-header">
        
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
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::label(Yii::t('rbac', 'Role Name')); ?>
                <?= Html::textInput('name', $role->name, ['class' => 'form-control']); ?>
            </div></div>

        <div class="col-md-6">
            <div class="form-group">
                <?= Html::label(Yii::t('rbac', 'Description')); ?>
                <?= Html::textInput('description', $role->description, ['class' => 'form-control']); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::label(Yii::t('rbac', 'Permissions')); ?>
            <?= Html::checkboxList('permissions', $role_permit, $permissions, ['separator' => '<br>']); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('rbac', 'Submit'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
