<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\models\User;
use common\models\UserProfile;
use bs\Flatpickr\FlatpickrWidget;
use vova07\fileapi\Widget as FileApi;

/* @var $this yii\web\View */
/* @var $profile common\models\UserProfile */
/* @var $user backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */

$this->title = Yii::t('_user', 'User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>

<?php
$modalf = 'signup-modal';
echo yii\bootstrap\Modal::widget([
    'id' => $modalf,
    'size' => 'modal-lg',
//    'clientOptions' => [
//        'backdrop' => false, 'keyboard' => false
//    ],
    'options' => ['tabindex' => false]
]);
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header">
                <h4><i class="fa fa-user"> <?= yii\helpers\Html::encode($this->title) ?></i></h4>
            </div>
            <div class="box-body">
                
                <div class="col-md-6 col-md-offset-3">
                    <?php $form = ActiveForm::begin() ?>
                    <div class="row">
                        <div class="col-md-12">
                    <?= $this->render('_image-upload', ['model' => $profile, 'form' => $form]) ?>
                        </div>
                    </div>

                    <div class="form-group field-userform-username">
                        <label>Username : <?= $user->username; ?></label>
                    </div>
                    <div class="form-group field-userform-password">
                    <label>Password : ******</label>
                    </div>

                    <?= $form->field($user, 'username')->hiddenInput(['maxlength' => true])->label(false) ?>

                    <?= $form->field($user, 'password')->hiddenInput(['maxlength' => true])->label(false) ?>

                    <?= $form->field($user, 'email')->textInput(['maxlength' => true])->label(Yii::t('_user','Email')) ?>



                    <?= $form->field($profile, 'firstname')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($profile, 'lastname')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($profile, 'birthday')->widget(kartik\date\DatePicker::ClassName(),
                    [
                    'name' => 'birthday', 
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]);?>



                     
                    <?=
                    $form->field($profile, 'gender')->dropDownlist(
                            [
                        UserProfile::GENDER_MALE => Yii::t('_user', 'Male'),
                        UserProfile::GENDER_FEMALE => Yii::t('_user', 'Female'),
                            ], ['prompt' => '']
                    )->label(Yii::t('_user','Gender'))
                    ?>

                    <?= $form->field($profile, 'sap_id')->textInput()->label(Yii::t('_user','Sap_id')) ?>
                    <?= $form->field($profile, 'sitecode')->textInput()->label(Yii::t('_user','Site Code'))?>  
                    <?= $form->field($profile, 'position')->textInput()->label(Yii::t('_user','Position'))?>

<?= $form->field($user, 'status')->label(Yii::t('_user', 'Status'))->radioList(User::statuses()) ?>

<div id="xxx">
<?= $form->field($user, 'roles')->checkboxList($roles)->label('บทบาท') ?>
</div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                    <?= Html::submitButton(Yii::t('_user', 'Save'), ['class' => 'btn btn-primary btn-block btn-lg']) ?>
                            </div>
                        </div>
                    </div>

<?php ActiveForm::end() ?>
                </div>

            </div>
        </div>

    </div>
</div>
<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('.btnAddSite').on('click', function () {
        $('#<?= $modalf ?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#<?= $modalf ?>').modal('show');
        let url = '/sitecode/save';
        $.get(url, function (res) {
            $('#<?= $modalf ?> .modal-content').html(res);
        });
        return false;
    });
    
    
</script>
<?php richardfan\widget\JSRegister::end(); ?> 
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
