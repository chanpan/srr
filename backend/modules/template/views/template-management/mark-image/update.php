<?php 
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use appxq\sdii\helpers\SDNoty;
    use appxq\sdii\helpers\SDHtml;
?> 
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?= $model->name;?></h4>    
</div>
<?php 
    $form = ActiveForm::begin([
        'id'=>$model->formName(),
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]);
?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-2 text-center">
            <div>
                <?php 
                    $src = Yii::getAlias('@storageUrl')."{$model->path}/{$model->name}";                        
                    echo yii\helpers\Html::img($src,['style'=>'width:80px']);
                ?>
            </div>
        </div>
        <div class="col-md-10">            
            <div class="col-md-12">
                <div class="form-group">
                    <?php 
                        echo kartik\file\FileInput::widget([
                            'name' => 'file',
                            'id'   =>'file',
                            'pluginOptions' => [
                                'showPreview' => false,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => false,
                                //'mainClass' => 'input-group-lg'
                            ]
                        ]);
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'code')->textarea()?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'default')->inline()->radioList(['1'=>'Yes', '0'=>'No'], [])?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'detail')->textInput()?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'default_image')->inline()->radioList(['1'=>'Yes', '0'=>'No'], [])?>
            </div>
        </div>
        
            
    </div>
    
</div>
<div class="modal-footer">
    <div class="col-md-6 col-md-offset-3">
        <?= Html::submitButton('Submit',['class'=>'btn btn-primary btn-lg btn-block btnSubmit']) ?>
    </div>
</div>

<?php ActiveForm::end()?>
 
<?php  \richardfan\widget\JSRegister::begin(); ?>
<script>  
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {      
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
           if(result.status == 'success') {
                <?= SDNoty::show('result.message', 'result.status')?>           
                $('#modal-mark').modal('toggle');
                $.pjax.reload({container: "#pjax-water", async:false});
            } else {
                <?= SDNoty::show('result.message', 'result.status')?>
            } 
        }
    });    
     
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>