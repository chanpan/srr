<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserProfile;
use janpan\jn\widgets\FlatpickrWidget;
use vova07\fileapi\Widget as FileApi;
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
    
    <div class="col-md-7" style="border-right: 1px solid #57a19f;">
        <?php
        $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => $model->formName(),
                'fieldConfig' => [
                    'horizontalCssClasses' => [
                        'label' => 'col-md-3',
                        'offset' => 'col-sm-offset-2',
                        'wrapper' => 'col-md-6',
                    ],
                ],
        ]);
        ?>
        <div class="row">
            <div class="col-md-12">
                    <?= $this->render('_image-upload', ['model' => $model, 'form' => $form]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"> 
                <?=
                $form->field($model, 'birthday')->widget(kartik\date\DatePicker::ClassName(), [
                    'name' => 'birthday',
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-12">
                <?=
                $form->field($model, 'gender')->dropDownlist([
                    UserProfile::GENDER_MALE => Yii::t('_user', 'Male'),
                    UserProfile::GENDER_FEMALE => Yii::t('_user', 'Female'),
                        ], ['prompt' => Yii::t('_user', 'Select Gender')])
                ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group field-userprofile-gender">
                <label class="control-label col-sm-3" style="padding-left: 0px;" for="userprofile-approval"><?= Yii::t('_user', 'Status') ?></label>
                <div class="col-md-6">
                    <?php
                        if ($model->approval == '1') {
                            echo "<div class='label label-success'><i class='fa fa-check-circle'></i> " . Yii::t('_user', 'Approval') . "</div>";
                        } else {
                            echo "<div class='label label-warning'>" . Yii::t('_user', 'Pending') . "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group field-userprofile-gender">
                <label class="control-label col-sm-3" style="padding-left: 0px;" for="userprofile-sap_id"><?= Yii::t('_user', 'Sap ID') ?></label>
                <div class="col-md-6"><i class="fa fa-key"></i> <?= $model->sap_id ?></div>
            </div>
        </div>
        <div class="col-md-12" style="padding-left:0">
            <?php
            echo $form->field($model, 'sitecode')->textInput()->label(Yii::t('_user', 'Site Code'));
            ?>             
        </div>
        <div class="col-md-12" style="padding-left:0">
            <?php
            echo $form->field($model, 'position')->textInput()->label(Yii::t('_user', 'Position'));
            ?>         
        </div>
        <div class="col-md-6 col-md-offset-3">
            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success btn-block btn-lg categorie-search-box button']) ?>
        </div>
<?php ActiveForm::end() ?>
    </div>
    <div class="col-md-5">
        <?= $this->render("_account",['model'=>$user]);?>
    </div>
</div>

<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('.btnAddSite').on('click', function () {
        $('#<?= $modalf ?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#<?= $modalf ?>').modal('show');
        let url = '/account/sitecode/create';
        $.get(url, function (res) {
            $('#<?= $modalf ?> .modal-content').html(res);
        });
        return false;
    });

    $('form#<?= $model->formName() ?>').on('beforeSubmit', function (e) {
        var $form = $(this);
        $.post(
                $form.attr('action'), //serialize Yii2 form
                $form.serialize()
                ).done(function (result) {
            if (result.status == 'success') {
<?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
                $(document).find('#signup-modal').modal('hide');

            } else {
<?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
            }
        }).fail(function () {
<?= appxq\sdii\helpers\SDNoty::show("'" . appxq\sdii\helpers\SDHtml::getMsgError() . "Server Error'", '"error"') ?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php richardfan\widget\JSRegister::end(); ?> 

<?php appxq\sdii\widgets\CSSRegister::begin() ?>
<style>
    .select2-container--krajee .select2-selection--single {
        height: 35px;
        line-height: 1.428571;
        padding: 12px 24px 6px 12px;
    }
    .select2-container--krajee .select2-selection__clear {
        color: #000;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        top: 0.2rem;
        font-weight: 700;
        font-size: 20px;
        opacity: 0.4;
        filter: alpha(opacity=40);
        position: absolute;
        left: 85%;
    }
    #save-upload{color:#fff;}
    
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>


