<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\models\User;
use common\models\UserProfile;
use bs\Flatpickr\FlatpickrWidget;
use vova07\fileapi\Widget as FileApi; 
$this->title = Yii::t('_user', 'User Profile');

$this->params['breadcrumbs'][] = $this->title;
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
                    <?= $this->render('_image-upload', ['model' => $profile, 'form' => $form]) ?>

                    <?= $form->field($user, 'username')->textInput(['maxlength' => true])->label(Yii::t('_user','Username')) ?>

                    <?= $form->field($user, 'password')->passwordInput(['maxlength' => true])->label(Yii::t('_user','Password')) ?>

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

                    
                    <?= $form->field($profile, 'sap_id')->textInput()->label(Yii::t('_user','Sap_id')) ?>
<?=
$form->field($profile, 'sex')->dropDownlist(
                                               [
                                               UserProfile::GENDER_MALE => Yii::t('_user', 'Male'),
                                               UserProfile::GENDER_FEMALE => Yii::t('_user', 'Female'),
                                               ], ['prompt' => '']
                                               )->label(Yii::t('_user','Gender'))
?>
                    <?php
                        echo $form->field($profile, 'sitecode')->textInput()->label('หน่วยงาน');
                    ?>
                    <?php
                        echo $form->field($profile, 'position')->textInput()->label('ตำแหน่ง');
                    ?>  
                      

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
