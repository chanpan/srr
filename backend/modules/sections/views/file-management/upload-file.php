<?php 
    use yii\helpers\Html;
    kartik\file\FileInputAsset::register($this);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="itemModalLabel">Upload Files</h4>
</div>
<div class="modal-body">
    <?php
        $url_upload = "";
        $accept = '';
        if ($model->file_type == 2 || $model->file_type == 6) {            
            $accept = 'image/*';
        } else if ($model->file_type == 3) {//วีดีโอ (ตัดต่อ)
            $accept = 'video/*';
            echo "<label>Select video type</label>";
            echo Html::radioList("status", 1, ['1'=>'footage', '2'=>'video clip'], ['id'=>'status']);
        }else if ($model->file_type == 4) { //audio
            $accept = 'audio/*';            
        }
        else if ($model->file_type == 5) {//document 
            $accept = '*';
        }
    ?>
    <div class="file-loading">
        <input id="input-700" name="name[]" type="file" multiple accept="<?= $accept?>">
    </div>
</div>
<div class="modal-footer">
    <div class="col-md-4 col-md-offset-4">
        <?= Html::submitButton('Close',['class'=>'btn btn-warning btn-lg btn-block btnClose', 'data-dismiss'=>'modal']) ?>
    </div>
</div>
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $('.btnSubmit').prop('disabled', true); 
    
    $("#input-700").fileinput({        
        uploadUrl: "<?= yii\helpers\Url::to(['/sections/file-management/upload-file'])?>",
        minFileCount:0,
        maxFileCount:1000,
        showUpload:false,
        showRemove:false,
        uploadExtraData: function() {
            return {
                content_id: "<?= Yii::$app->request->get('content_id', '')?>",
                file_type: "<?= $model->file_type?>",
                status: $('input[name=status]:checked').val() 
            };
        },
        //ajaxSettings: { headers: { Authorization: 'Bearer ' + localStorageService.get('authorizationData').token } }    
    }).on("filebatchselected", function(event, files) {
        $("#input-700").fileinput("upload");
        $('.btnClose').prop('disabled', true);
    }).on('filebatchuploadcomplete', function (event, data, previewId, index) {
          let result = {message:'Upload success', status:'success'};
          <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
          $('.btnClose').prop('disabled', false);
    }).on('filebatchuploaderror', function (event, data, previewId, index) {
          let result = {message:'Upload error', status:'error'};
          <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
         $('.btnClose').prop('disabled', false);
    });
    $(document).on('hide.bs.modal','#file-modal', function () {
      location.reload();
    //Do stuff here
   }); 
    
</script>
<?php \richardfan\widget\JSRegister::end();?>

