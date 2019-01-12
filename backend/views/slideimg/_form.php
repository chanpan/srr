<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model common\models\Slideimg */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="slideimg-form">

    <?php
    $form = ActiveForm::begin([
                'id' => $model->formName(),
                'options' => ['enctype' => 'multipart/form-data'] // important
    ]);
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel">Slideimg</h4>
    </div>

    <div class="modal-body"> 
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label><?= Yii::t('section', 'Desired image size') ?>: 1300x450 px</label>
                        <?php
                        $initImage = '';
                        if ($model->name) {
                            ///$imageArr = appxq\sdii\utils\SDUtility::string2Array($model->logo_image);
                            $initImage = "{$model->view_path}/{$model->name}";
                        }
                        echo kartik\file\FileInput::widget([
                            'name' => 'file',
                            'id' => 'file',
                            'options' => ['multiple' => false, 'accept' => 'image/*'],
                            'pluginOptions' => [
                                //'name'=>'name',
                                'initialPreview' => [
                                    $initImage,
                                ],
                                'initialPreviewAsData' => true,
                                'overwriteInitial' => false,
                                'maxFileSize' => 2800,
                                'maxFileCount' => 1,
                                //'showPreview' => false,
                                'showCaption' => true,
                                'showRemove' => false,
                                'showUpload' => false
                            ]
                        ]);
                        ?>
                    </div>
                    <?= $form->field($model, 'url')->textInput() ?> 
<?= $form->field($model, 'detail')->textarea(['rows' => 6])->label(Yii::t('section', 'Caption ใต้ภาพ')) ?>
<?= $form->field($model, 'forder')->textInput()->label(Yii::t('section', 'Order')) ?> 


                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>

<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
// JS script
    $('form#<?= $model->formName() ?>').on('beforeSubmit', function (e) {
        var $form = $(this);
        var formData = new FormData($(this)[0]);
        $('.btn').prop('disabled', true);
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            success: function (result) {
                if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                    $('#modal-slideimg').modal('toggle');
                    //$.pjax.reload({container: "#slideimg-grid-pjax", async: false});
                    setTimeout(function(){
                        location.reload();
                    },1000);
                    $('.btn').prop('disabled', false);
                } else {
<?= SDNoty::show('result.message', 'result.status') ?>
                    $('.btn').prop('disabled', false);
                }
            }
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>