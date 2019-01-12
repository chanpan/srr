<?php 
    use yii\helpers\Html;
    $title = "Invoice Detail";
?>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="row">
    <div class="col-md-6 col-md-offset-3" style="margin-top:100px;">
        <div class="panel panel-default">            
            <div class="panel-body">
                <p class="pull-right"><?= appxq\sdii\utils\SDdate::mysql2phpDate($model->create_date)?></p>
                <h3 class="text-center"><?= Html::encode('SIRIRAJ MUSEUM')?></h3>
                <h3 class="text-center"><label class="label label-primary" style="padding:10px;border-radius:0;">ใบกำกับภาษี <?= Html::encode($model->id)?></label></h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <h4><?= Html::encode($model->shipper->firstname)?> <?= Html::encode($model->shipper->lastname)?></h4>
                </div>
                <div class="col-md-6">
                    <h5><?= Html::encode($model->shipper->companey_name)?></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <table class="table table-bordered table-responsive table-striped">
            <thead>
                <tr>
                    <th><?= Yii::t('order', 'File name')?></th>
                    <th><?= Yii::t('order', 'Meta text')?></th>
                    <th><?= Yii::t('order', 'Description')?></th>
                    <th><?= Yii::t('order', 'Size')?></th>
                    <th><?= Yii::t('order', 'Quantity')?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($order as $key=>$value):?>
                    <tr>
                        <td><?= isset($value->files->file_name_org) ? $value->files->file_name_org : ''?></td>
                        <td><?= isset($value->files->meta_text) ? $value->files->meta_text : ''?></td>
                        <td><?= isset($value->files->description) ? $value->files->description : ''?></td>
                        <td><?= isset($value->size) ? $value->size : ''?></td>
                        <td><?= isset($value->quantity) ? $value->quantity : ''?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>   
        </table>
    </div>
</div>