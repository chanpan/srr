 <?php 
    use yii\bootstrap\ActiveForm;
    
    $form = ActiveForm::begin([
        'id'=>$model->formName(),
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'offset' => 'col-sm-offset-3',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);
 ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?= Yii::t('user','Create Sitecode')?></h4>
</div>
<div class="modal-body">    
    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'name') ?>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= yii\helpers\Html::submitButton(Yii::t('user','Submit'), ['class'=>'btn btn-lg btn-primary btn-block'])?>
        </div>
    </div>
</div>

<?php ActiveForm::end();?>



<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
        var $form = $(this);
        $.post(
            $form.attr('action'), //serialize Yii2 form
            $form.serialize()
        ).done(function(result) { 
            if(result.status == 'success') {
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
                $(document).find('#signup-modal').modal('hide');
                
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