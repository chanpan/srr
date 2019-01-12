<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
// รอ / ส่งข้อมูลแล้ว / ไม่อนุมัติ 
$this->title = Yii::t('order', 'แก้ไขสถานะคำร้องขอข้อมูล');
?>

<div class="order-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title);?></h4>
    </div>

    <div class="modal-body">	 
	<?php
            $items = ['1'=>'รอพิจารณา' , '2'=>'ส่งข้อมูลแล้ว', '3'=>'ไม่อนุมัติ'];
            echo $form->field($model, 'status')->radioList($items, [])->label(false);
        ?>
        <?= $form->field($model, 'conditions')->textarea()->label('หมายเหตุ')?>
    </div>
    
    <div class="modal-footer">
        <div class="col-md-4 col-md-offset-4">
            <?= Html::submitButton('Submit',['class'=>'btn btn-lg btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            $(document).find('#modal-order').modal('hide');
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
