<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model frontend\modules\account\models\SignupForm */

$this->title = Yii::t('user', 'Sign up');

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
<div class="" style="margin-top:30px;">
    
    <div class="row">
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
                    'id' => $model->formName(),
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'label' => 'col-md-3',
                            'offset' => 'col-sm-offset-2',
                            'wrapper' => 'col-md-6',
                            'hint' =>  'col-md-6 col-sm-offset-3',
                        ],
                    ],
                ])
        ?>
        <div class="col-md-8">
            
            <div class="panel panel-default">
                <div class="panel-heading"><?= Html::encode($this->title) ?></div>
                <div class="panel-body">
                    <label style="color:red;margin-bottom:20px;">**  <?= Yii::t('_user','Siriraj members wait 1-2 days for staff approval.')?></label>
                    
                     
                    <div class="col-md-12">
                        <?= $form->field($model, 'username')
                ->textInput(['maxlength' => true, 'autofocus'=>'autofocus','placeholder'=>'ควรกรอกเป็นภาษาอังกฤษ']) ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true]) ?>

                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'firstname')->textInput()->label('ชื่อจริง') ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'lastname')->textInput()->label('นามสกุลจริง') ?>
                    </div>
                            <div class="col-md-12">
                                
                                <div class="clearfix"></div>
                                <div class="col-md-3"></div>
                                <label class="col-md-6">
                                    <input type="checkbox" id='checkAllow' name='checkallow' class="btn btn-info" data-toggle="collapse" data-target="#demo"> บุคลากรของคณะแพทยศาสตร์ศิริราชพยาบาล
                                </label>
                            </div>
                    
                    <div id="demo" class="collapse">
                         <div class="col-md-12 error-fields">
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'sap_id')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-12">
                                <?php   
                                  echo $form->field($model, 'sitecode')->textInput()->label(Yii::t('user','Sitecode'));      
                                ?>             
                            </div>
                            <div class="col-md-12">
                                <?php   
                                  echo $form->field($model, 'position')->textInput()->label(Yii::t('user','Position'));      
                                ?>             
                            </div> 
                    </div>
                    
                            

                </div>
                
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <?= Html::submitButton(Yii::t('user', " ลงทะเบียน"), ['class' => 'btn btn-success btn-block btn-lg btnSubmitRegister']) ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="text-center">
                <label style="color:red;margin-bottom:20px;">หมายเหตุ * คือข้อบังคับต้องกรอก</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>สิทธิ์สมาชิกทั่วไป</h3>
                        1. ดาวน์โหลด ภาพนิ่งขนาด 1024x768 pixel<br>
                        2. ดาวน์โหลด ข้อมูลอักษร (PDF)<br>
                        <br>
                    <h3>สิทธิ์สมาชิกศิริราช</h3>
                        1.ดาวน์โหลด ภาพนิ่งขนาด 2124x1414  pixel<br>
                        2.ดาวน์โหลด ข้อมูลอักษร (PDF)<br>
                        3.ดาวน์โหลด เสียงและวีดีโอ<br>
                </div>
            </div>
        </div>
        
        <?php ActiveForm::end() ?>
    </div>
</div>  

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
    .btn{
        font-size:18pt;
    }

</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>
 <?php $this->registerCss("
    div.required label.control-label:after {
        content: \" *\";
        color: red;
    }
")?>



<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
        $('.btnSubmitRegister').attr('disabled', true);
        //checkAllow
        $('input[name="checkallow"]:checked').each(function() {
                                                   if(this.value == 'on'){
                                                   
                                                        if($('#signupform-sap_id').val() == '' || $('#signupform-sitecode').val() == '' || $('#signupform-position').val() == ''){
                                                            $('.error-fields').html(`
                                                                           
                                                                           <div class='alert alert-danger alert-dismissible'>
                                                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                                    กรุณากรอกข้อมูลบุคลากรให้ครบ</div>`);
                                                                            $('.btnSubmitRegister').attr('disabled', false);
                                                            return false;
                                                        }
                                                   
                                                   }
        });
                                          
        var $form = $(this);
        $.post(
            $form.attr('action'), //serialize Yii2 form
            $form.serialize()
        ).done(function(result) {
            $('.btnSubmitRegister').attr('disabled', false);
            if(result.status == 'success') {
                <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
            } else {
                <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
            } 
            
        }).fail(function() {
            $('.btnSubmitRegister').attr('disabled', false);
            <?= \appxq\sdii\helpers\SDNoty::show("'" . \appxq\sdii\helpers\SDHtml::getMsgError() . "Server Error'", '"error"')?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php richardfan\widget\JSRegister::end(); ?> 
