<?php
namespace developeruz\db_rbac\views\access;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Links */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('rbac', 'Add Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Permission'), 'url' => ['permission']];
$this->params['breadcrumbs'][] = Yii::t('rbac', 'Add Permission');
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
            <?= Html::textInput('description'); ?>
        </div>

        <div class="form-group">
            <?= Html::label(Yii::t('rbac', 'Permission name')); ?>
            <?= Html::textInput('name'); ?>
            <?php //Yii::t('db_rbac', '<br>* Формат: <strong>module/controller/action</strong><br><strong>site/article</strong> - доступ к странице "site/article"<br><strong>site</strong> - доступ к любым action контроллера "site"');?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('rbac', 'Submit'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
