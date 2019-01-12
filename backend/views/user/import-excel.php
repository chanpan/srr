<?php

use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use appxq\sdii\helpers\SDNoty;
use yii\helpers\Url;

$this->title = "เพิ่มผู้ใช้จากไฟล์ Excel";
?> 
<?php
$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => $model->formName(),
        ]);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?= $this->title; ?></h4>
</div>
<div class="modal-body">

    <?php
    echo $form->field($model, 'filename')->widget(FileInput::classname(), [
//        'options' => ['accept' => 'csv'],
            ])->label('ไฟล์')
            ->hint(
                    "<span style='color:#F44336;'>* หมายเหตุ ขนาดข้อมูลในไฟล์ Excel ไม่ควรเกิน 500 - 1000 แถว เนื่องจากจะทำให้ระบบช้า<br> และ รูปแบบข้อมูลจะต้องตรงตาม Template ตัวอย่าง เท่านั้น <br> และ ไฟล์จะต้องเป็น .xls , xlsx เท่านั้น</span>
                    <div><a href=" . \yii\helpers\Url::to('@web/files/001.xls') . "><i class=\"fa fa-download\"></i> ดาวน์โหลด Template  ตัวอย่าง</a></div>    
            ");
    ?>


    <hr>
    
    <div id="que_process"></div>
    <div class="progressbar"></div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= yii\helpers\Html::submitButton(Yii::t('user', 'Start'), ['class' => 'btn btn-lg btn-primary btn-block btnSubmit']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('form#<?= $model->formName() ?>').on('beforeSubmit', function (e) {
        
        $('.btnSubmit').prop('disabled', true);
        var $form = $(this);
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            success: function (result) {
                $('.btnSubmit').prop('disabled', false);
                if (result.status == 'success') {
                    let data = result['data'];
                    let count = data.length; //จำนวนทั้งหมด
                    let count_start = 0;
                    let count_success = 0;
                    let count_error = 0;
                    let count_end = count;
                    let pc = 0;
                    
                    updateData(count,count_start,count_success,count_error, count_end, '', 0);
                   let url = '<?= Url::to(['/user/save-user'])?>';
                    for(let i of data){
                       $.post(url ,i , function(res){
                           if(res.status == 'success'){
                               count_success += 1;
                           }else{
                               count_error += 1;
                           }
                           count_start += 1;
                           count_end -= 1;
                           if(count_end <= 0){
                               count_end = 0;
                           }
                           //pc
                           pc = (count_start/count)*100;
                           updateData(count,count_start,count_success,count_error, count_end, result, pc.toFixed(0));
                        });
                    }
                   
                } else {
                    let error = JSON.stringify(result.data);
                    <?= SDNoty::show('error', 'result.status') ?>
                }
            }
        }).fail(function () {
            $('.btnSubmit').prop('disabled', false);
        });

        return false;
    });
    
    function updateData(count,count_start,count_success,count_error, count_end, result, pc){
        $( ".progressbar" ).progressbar({
                value: parseInt(pc)
        });
        if(count_end == 0){
            <?= SDNoty::show('result.message', 'result.status') ?>
            setTimeout(function(){
                location.reload();
            },1000);
                    }                
        let html ='';
            html += `
               <div>จำนวนข้อมูลทั้งหมด : ${count} รายการ</div>
               <div>จำนวนข้อมูล ที่กำลังบันทึก : ${count_start} รายการ</div>
               <div>จำนวนข้อมูล ที่บันทึกสำเร็จ : ${count_success} รายการ</div>
               <div>จำนวนข้อมูล ที่บันทึกไม่สำเร็จ : ${count_error} รายการ</div>
               <div>จำนวนข้อมูล คงเหลือ : ${count_end} รายการ</div>
               <div>สถานะการทำงาน : ${pc} %</div>
            `;
            
            $('#que_process').html(html);
    }
</script>
<?php richardfan\widget\JSRegister::end(); ?> 
