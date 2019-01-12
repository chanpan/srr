<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model frontend\modules\account\models\PasswordResetRequestForm */

$this->title = Yii::t('frontend', 'ขอรีเซ็ตรหัสผ่าน');
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
        <?php if($status == 1):?>
            <div class="alert alert-success"><?= $message?></div>
        <?php elseif($status == 2):?>
            <div class="alert alert-warning"><?= $message?></div>     
        <?php endif;?>
        <?= $form->field($model, 'email')->textInput(['autofocus'=>'autofocus','autocomplete'=>"on"]) ?>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton(Yii::t('frontend', 'ส่ง'), ['id'=>'btnSubmit','class' => 'btn btn-success btn-block btn-lg btnRequest','data-loading-text'=>"Loading..."]) ?>
            </div>
        </div>

    <?php ActiveForm::end() ?>
</div>

</div>
<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
                                          $('.btnRequest').attr('disabled', true);
        var $form = $(this);
        $.post(
            $form.attr('action'), //serialize Yii2 form
            $form.serialize()
        ).done(function(result) {
              
               $('.btnRequest').attr('disabled', false);
            if(result.status == 'success') {
                <?= SDNoty::show('result.message', 'result.status')?>
                 
            } else {
                <?= SDNoty::show('result.message', 'result.status')?>
            } 
        }).fail(function() {
                $('.btnRequest').attr('disabled', false);
            <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php richardfan\widget\JSRegister::end(); ?> 
