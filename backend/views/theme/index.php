<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use kartik\color\ColorInput; 
  
 
 $this->title = Yii::t('_app', 'Themes');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]); ?>

    <div class="box-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-title" id="itemModalLabel"><?= Yii::t('section','Themes')?></div>
    </div>

    <div class="box-body"> 
        
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'bg_header')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?> </div>
            <div class="col-md-4"><?= $form->field($model, 'bg_menu')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?>  </div>
            <div class="col-md-4"><?= $form->field($model, 'bg_border_menu')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?> </div>
            <div class="col-md-4"><?= $form->field($model, 'bg_menu_link')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?> </div>
            <div class="col-md-4"><?= $form->field($model, 'bg_menu_link_hover')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?> </div>
            <div class="col-md-4"><?= $form->field($model, 'bg_footer')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?> </div>
            <div class="col-md-4"><?= $form->field($model, 'bg_footer_txt')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?></div>
            
            <div class="col-md-4"><?= $form->field($model, 'color_logo_text')->widget(ColorInput::classname(), ['pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb'],'options' => ['placeholder' => 'Select color ...'],]); ?></div>
            
            <div class="clearfix"></div>
            <div class="col-md-12">
               <?php 
               $initImage = '';
               if($model->logo_image){
                   $imageArr = appxq\sdii\utils\SDUtility::string2Array($model->logo_image);
                   $initImage = "{$imageArr['path']}/{$imageArr['name']}";
               }
               
               
                echo '<label class="control-label">Logo Image</label>';
                    echo kartik\file\FileInput::widget([
                        'name' => 'name',
                        'attribute' => 'name',
                        'options' => ['multiple' => false,'accept' => 'image/*'],
                        'pluginOptions' => [
                            //'name'=>'name',
                            'initialPreview'=>[
                                 $initImage,
                            ],
                            'initialPreviewAsData'=>true, 
                            'overwriteInitial'=>false,
                            'maxFileSize'=>2800,
                            'maxFileCount' => 1,
                            //'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => false,
                            'showUpload' => false
                        ]
                    ]);
               ?>
            </div>
        </div> 
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton(Yii::t('section', 'Save'), ['class' => 'btn btn-primary btn-block btn-lg']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
    $("#input-700").fileinput({});
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    $('.btnSubmit').prop('disabled', true);     
    var $form = $(this);
    var formData = new FormData($(this)[0]);
    $.ajax({
        url:$form.attr('action'),
        type:'POST',
        data:formData,
        processData: false,
        contentType: false,
        cache: false,         
        enctype: 'multipart/form-data',
        success:function(result){
           $('.btnSubmit').prop('disabled', false);
           if(result.status == 'success') {
                <?= SDNoty::show('result.message', 'result.status')?>           
                setTimeout(function(){
                    location.reload();
                },1000);
            } else {
                <?= SDNoty::show('result.message', 'result.status')?>
            } 
        }
    });    
     
    return false;
});

setTimeout(function(){
    $('.kv-file-remove').remove();
},500);
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>