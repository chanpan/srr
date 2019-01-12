<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */

$this->title = Yii::t('backend', 'Create user');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
    <div class="box-header">
        <h4><i class="fa fa-user"> <?= yii\helpers\Html::encode($this->title)?></i></h4>
    </div>
    <div class="box-body">
        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            
            <div id="xxx">
                <?= $form->field($model, 'status')->checkbox(['label' => Yii::t('backend', 'Activate')]) ?>
                <?= $form->field($model, 'roles')->checkboxList($roles) ?>
            </div>
            
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'sap_id')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'sitecode')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <?= Html::submitButton(Yii::t('backend', 'Submit'), ['class' => 'btn btn-primary btn-block btn-lg']) ?>
                    </div>
                </div>
            </div>
            
        <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

    </div>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .box-default {
         border: none;
         box-shadow: 0px 0px 1px #cacaca;
     }
     #xxx input[type="checkbox"] {
            cursor: pointer;
            /* -webkit-appearance: none; */
            appearance: none;
            background: #34495E;
            border-radius: 1px;
            box-sizing: border-box;
            position: relative;
            box-sizing: content-box;
            width: 30px;
            height: 22px;
            border-width: 0px;
            transition: all 0.3s linear;
            margin-right: 5px;
            position: relative;
            top: 8px;
            padding-right: 23px;
        }
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>
