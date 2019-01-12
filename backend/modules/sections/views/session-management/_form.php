<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use backend\widgets\TinyMCECallback;
use dosamigos\tinymce\TinyMce;
use dominus77\iconpicker\IconPicker;

$this->title = Yii::t('section','Siriraj Museum\'s Knowledge Management');
//คลังความรู้ของพิพิธภัณฑ์ศิริราช  Siriraj Museum's Knowledge Management
?>

<div>

    <?php
    $form = ActiveForm::begin([
                'id' => $model->formName(),
    ]);
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><b>&times;</b></button>
        <h4 class="modal-title" id="itemModalLabel"><b><?= Html::encode($this->title)?></b></h4>
    </div>

    <div class="modal-body">
        <div class="row"> 
            <div class="clearfix">
                <div class="col-md-5">  
                    
                    <?= $this->render('_image-upload', ['model' => $model, 'form' => $form]) ?>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('ไม่ควรเกิน 100 ตัวอักษร') ?> 
                    </div>
                </div>
                <div class="col-md-2" style="display:none;">
                    <div class="col-md-2">
                        <?php
                        $model->public = ($model->public != '') ? $model->public : 1;
                        echo $form->field($model, 'public')->inline()->radioList(['1' => Yii::t('section', 'Yes'), '2' => Yii::t('section', 'No')])
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix" style="display:none;">
                    <div class="col-md-8">
                        <?php
                        $parent_list = \yii\helpers\ArrayHelper::map($parent_section, 'id', 'name');
                        echo $form->field($model, 'parent_id')->dropDownList($parent_list, ['prompt' => Yii::t('section', 'Select Section')]);
                        ?>
                    </div> 
            </div> 
            
            <div class="col-md-12">
                <div class="col-md-12">
                    <?php  echo $form->field($model, 'detail')->textarea(['rows'=>'6']);?>
                </div>
            </div>

            
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton("Submit", ['class'=>'btn btn-primary btn-block btn-lg'])?>
                <?php // Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-block btn-lg' : 'btn btn-primary btn-block btn-lg']) ?>
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
    $('#modal-contents').bind('hidden.bs.modal', function () {
        if (window.tinyMCE !== undefined && tinyMCE.editors.length) {
            for (e in tinyMCE.editors) {
                tinyMCE.editors[e].destroy();
            }
        }
    });
// JS script
    $('form#<?= $model->formName() ?>').on('beforeSubmit', function (e) {
        var $form = $(this);
        $.post(
                $form.attr('action'), //serialize Yii2 form
                $form.serialize()
                ).done(function (result) {
            if (result.status == 'success') {//console.log(result);return false;
                <?= SDNoty::show('result.message', 'result.status') ?>
                $(document).find('#modal-contents').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 1000);
                if (result.action == 'create') {
                    //$(\$form).trigger('reset');
                    $(document).find('#modal-sections').modal('hide');
                    $.pjax.reload({container: '#sections-grid-pjax'});
                } else if (result.action == 'update') {
                    $(document).find('#modal-sections').modal('hide');
                    $.pjax.reload({container: '#sections-grid-pjax'});
                }

            } else {
<?= SDNoty::show('result.message', 'result.status') ?>
            }
        }).fail(function () {
<?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"') ?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>