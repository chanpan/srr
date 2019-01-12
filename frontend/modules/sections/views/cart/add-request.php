<?php 
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;
?>
<?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'layout' => 'horizontal',
                    'id' => $model->formName(),
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'label' => 'col-md-3',
                            'offset' => 'col-sm-offset-2',
                            'wrapper' => 'col-md-8',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
                ])
        ?>
            
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" style="color:#fff;"><b>ขอความอนุเคราะห์ข้อมูล</b></h4>
</div>
<div class="modal-body">
    <h2 class="text-center">
        เรื่อง  ขอความอนุเคราะห์ข้อมูล<br>
        เรียน หัวหน้าหน่วยพิพิธภัณฑ์ศิริราช
    </h2>
<input type='hidden' value='<?= $order_id; ?>' name='order_id' />
    <?= $form->field($model, 'id')->hiddenInput()->label(FALSE);?>
    <?= $form->field($model, 'firstname')->textInput()?>
    <?= $form->field($model, 'lastname')->textInput()?>
    <?= $form->field($model, 'position')->textInput()?>
    <?= $form->field($model, 'sitecode')->textInput()?>
    <?= $form->field($model, 'tel')->textInput()?>
    <?= $form->field($model, 'email')->textInput()?>
    <?php  echo $form->field($model, 'note')->widget(\janpan\jn\widgets\FroalaEditorWidget::className(), [
            'toolbar_size'=>'sm',
            'options'=>['class'=>'eztemplate'],
        ]);//->hint('Default Template <a class="btn btn-warning btn-xs btn-template" data-widget="{tab-widget}">Use Default</a>'); 
    ?>
    <div style="color:red;text-align: center;">* ต้องกรอกทุกช่องตามความจริง</div>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3><b>รายการคำร้องขอ มีดังนี้</b></h3>
            <div><?= $product?></div><hr>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 col-md-offset-3">
            <b>  หมายเหตุ: เมื่อเจ้าหน้าที่ได้รับคำร้องขอความอนุเคราะห์ข้อมูล และผ่านการพิจารณาอนุมัติแล้ว เจ้าหน้าที่จะจัดส่งข้อมูลไปยังอีเมล์ที่แจ้งไว้ ภายใน 3 วัน</b>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="col-md-6 col-md-offset-3">
        <?= \yii\helpers\Html::submitButton('ส่งคำร้อง', ['class'=>'btn btn-primary btn-block btn-lg'])?>
    </div>
</div>
<?php ActiveForm::end() ?>  

<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
        var $form = $(this);
        $.post(
            '<?= Url::to(['/sections/cart/save-request'])?>', //serialize Yii2 form
            $form.serialize()
        ).done(function(result) {
            if(result.status == 'success') {
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
               setTimeout(function(){
                          location.href = '<?= Url::to(['/sections/order/my-order'])?>';
            },1000);
                //$(document).find('#modal-request').modal('hide');
            } else {
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
            } 
        }).fail(function() {
            <?= appxq\sdii\helpers\SDNoty::show("'" . appxq\sdii\helpers\SDHtml::getMsgError() . "Server Error'", '"error"')?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php richardfan\widget\JSRegister::end(); ?> 
