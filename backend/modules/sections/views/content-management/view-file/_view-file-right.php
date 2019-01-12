<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="col-md-4 view-file-right">
    <div class="box box-primary">
        <div class="box-body">
            <div class="pull-right">
                <?php
                echo Html::button("<i class='fa fa-pencil'></i> ", [
                    'content-id' => isset($_GET['content_id']) ? $_GET['content_id'] : '',
                    'filet-id'=> isset($dataDefault['id']) ? $dataDefault['id'] : '',
                    'data-action' => 'create-choice',
                    'class' => 'btn btn-primary btnCalls',
                    'title' => Yii::t('appmenu', 'Edit'),
                    'data-url' => Url::to(['/sections/file-management/create'])
                ]);
                //appxq\sdii\utils\VarDumper::dump($dataDefault);
                ?> 
            </div>
            <label>
                <i class="fa fa-info-circle" aria-hidden="true"></i> <?= Yii::t('Section','Note')?>
            </label>
            <div class="border-bottom">
                <div style="word-wrap: break-word;"><?= $dataDefault['details'] ?></div>
            </div>     
            <div class="border-bottom">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> <?= Yii::t('Section','By')?> : <?= \common\modules\cores\User::getProfileNameByUserId($dataDefault['user_create']) ?>
                    <br> <i class="fa fa-calendar"></i> วันที่อัปโหลด <?= \appxq\sdii\utils\SDdate::mysql2phpDateTime($dataDefault['create_date'])?>
                </label>    
            </div>

        </div>
    </div>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .view-file-right{      
        padding:5px;   
    }
    .border-bottom{
        border-bottom: 1px solid #ecf0f5;
        border-bottom-style: dashed;
        padding-bottom: 10px;
        padding-top: 10px;
    }
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>

<?php
$modal = "modal-contents";
?>
<?php \richardfan\widget\JSRegister::begin(); ?>

<script>
    $(".btnCalls").on('click', function () {
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        let filet_id = $(this).attr('filet-id');
        let content_id = $(this).attr('content-id');
        let params = {filet_id: filet_id, content_id: content_id};
        $('#<?= $modal ?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#<?= $modal ?>').modal('show');
        $.get(url, params, function (res) {
            $('#<?= $modal ?> .modal-content').html(res);
        });
        return false;
    });

</script>
<?php \richardfan\widget\JSRegister::end(); ?>