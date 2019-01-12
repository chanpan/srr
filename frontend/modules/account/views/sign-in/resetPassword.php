<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model frontend\modules\account\models\ResetPasswordForm */

$this->title = Yii::t('frontend', 'รีเซ็ตรหัสผ่าน');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'layout' => 'horizontal',
                    'id' => $model->formName(),
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'label' => 'col-md-3',
                            'offset' => 'col-sm-offset-2',
                            'wrapper' => 'col-md-6',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
                ])
        ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('รหัสผ่านใหม่') ?>

        <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true])->label('ยืนยันรหัสผ่าน') ?>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton(Yii::t('frontend', 'บันทึก'), ['class' => 'btn btn-success btn-block btn-lg']) ?>
            </div>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
        
        var $form = $(this);
        $.post(
            $form.attr('action'), //serialize Yii2 form
            $form.serialize()
        ).done(function(result) {
            if(result.status == 'success') {
                <?= SDNoty::show('result.message', 'result.status')?>
                let url = '<?= \yii\helpers\Url::to(['/account/sign-in/login'])?>';
                setTimeout(function(){
                    location.href = url;
                },1000);
                 
            } else {
                <?= SDNoty::show('result.message', 'result.status')?>
            } 
        }).fail(function() {
            <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php richardfan\widget\JSRegister::end(); ?> 