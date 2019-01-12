 <?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use dosamigos\tinymce\TinyMce;
use backend\widgets\TinyMCECallback;
use backend\modules\sections\classes\JSection;
janpan\jn\assets\croppie\JCroppieAssets::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\Contents */
/* @var $form yii\bootstrap\ActiveForm */
$this->title = Yii::t('content', 'Content');

?>

<div class="contents-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>    

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><b><?= Html::encode($this->title);?></b></h4>
    </div>

    <div class="modal-body">
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">

                    <?php
                    echo "<label>Section</label>";
                    $model->section_id = (isset($sec_id)) ? $sec_id : '';
                    $section_arr = JSection::getSectionById($model->section_id);
                    $section = isset($section_arr) ? $section_arr['name'] : '';
                    echo Html::textInput('section', $section, ['readonly' => 'readonly', 'class' => 'form-control']);
                    echo Html::hiddenInput('section_id', $model->section_id);
                    ?>
                </div> 
            </div>
            <div class="col-md-12">
                <?= $this->render('_image-upload', ['model' => $model, 'form' => $form]) ?>
            </div>
            <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> 
                <?php  echo $form->field($model, 'description')->widget(\janpan\jn\widgets\FroalaEditorWidget::className(), [
                        'toolbar_size'=>'lg',
                        'options'=>['class'=>'eztemplate'],
                    ]);//->hint('Default Template <a class="btn btn-warning btn-xs btn-template" data-widget="{tab-widget}">Use Default</a>'); 
                ?>
            


            <?php 

                $model->public = ($model->public != '') ? $model->public : isset($public) ? $public : '1';
                echo $form->field($model, 'public')
                        ->inline()
                        ->radioList(['1' => Yii::t('section', 'Pulbic'), '2' => Yii::t('section','Private')])
            ?> 
        </div>
        </div>
        
        

    </div>
    <div class="modal-footer">
       <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton("Submit", ['class'=>'btn btn-primary btn-block btn-lg'])?>
                <?php // Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-block btn-lg' : 'btn btn-primary btn-block btn-lg']) ?>
        </div>  
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
$('#modal-contents').bind('hidden.bs.modal', function() {
    if(window.tinyMCE !== undefined && tinyMCE.editors.length){
        for(e in tinyMCE.editors){
            tinyMCE.editors[e].destroy();
        }
    }
});     
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            setTimeout(function(){
                location.reload();
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
<?php  \richardfan\widget\JSRegister::end(); ?>