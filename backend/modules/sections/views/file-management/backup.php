<?php 
//    use kartik\widgets\FileInput;
    use yii\bootstrap\ActiveForm;
    use kartik\file\FileInput;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use appxq\sdii\helpers\SDNoty;
    use appxq\sdii\helpers\SDHtml;
    kartik\file\FileInputAsset::register($this);
?>
<?php 
    $form = ActiveForm::begin([
        'id'=>$model->formName(),
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]);
//\appxq\sdii\utils\VarDumper::dump($model);
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="itemModalLabel">Upload Files</h4>
</div>

<div class="modal-body"> 
    <?php //$form->field($model, 'name')->textInput()?>
    <?php 
    $url_upload = "";
    $accept = '';
    if($model->file_type == 2 || $model->file_type == 6){
        $url_upload = Url::to(['/sections/file-management/upload-file']);
        $accept = 'image/*';
    }
    else if($model->file_type == 3){//วีดีโอ (ตัดต่อ)
        $accept = 'video/*';
    }
    else if($model->file_type == 5){//document 
        $accept = '*';
    }  
//    echo FileInput::widget([
//        'name' => 'name[]',
//        'options' => ['multiple' => true,'id'=>'input-705','accept'=>$accept],
//        'pluginOptions' => [
//            'uploadAsync'=> false,
//            //'showUpload'=> false, // hide upload button
//            'showRemove'=> false, // hide remove button
//            'uploadUrl' => $url_upload,
//            'minFileCount'=> 0,
//            'maxFileCount' => 100,
//             
//        ]
//    ]);
 
    ?>
 <div class="file-loading">
    <input id="input-705" name="name[]" type="file" multiple>
 </div>
</div>
<div class="modal-footer">
    <div class="col-md-4 col-md-offset-4">
        <?= Html::submitButton('Submit',['class'=>'btn btn-primary btn-lg btn-block btnSubmit']) ?>
    </div>
</div>

<?php ActiveForm::end()?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script> 
   $("#input-705").fileinput({
        uploadAsync: false,
        uploadUrl: "<?= Url::to('/sections/file-management/upload-file')?>",
        uploadExtraData: function() {
            return {
                content_id: "<?= Yii::$app->request->get('content_id', '')?>",
                file_type: "<?= $model->file_type?>"
            };
        } 
     
   }); 
   // $('.btnSubmit').prop('disabled', true);
    $("#input-705").fileinput({         
    }).on("filebatchselected", function(event, files) {
        //$("#input-705").fileinput("upload");
        $('.btnSubmit').prop('disabled', false);
    });
    
// JS script
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
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>