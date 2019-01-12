<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use kartik\tabs\TabsX;

$this->title = Yii::t('section', $title);
if ($breadcrumb) {
    foreach ($breadcrumb as $b) {
        $this->params['breadcrumbs'][] = $b;
    }
}
$modal = "modal-contents";
?>
<?php foreach ($file_type as $key => $f): ?>
    <?php if ($key > 0): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <span class="pull-right">
                            
                            <?php
                            echo yii\helpers\Html::button("<i class='fa fa-plus'></i>", [
                                'data-id' => $f['id'],
                                'data-parent_id' => Yii::$app->request->get('id', '0'),
                                'file_type' => $f['id'],
                                'data-action' => 'create',
                                'class' => 'btn btn-success btnCreateFile',
                                'title' => Yii::t('appmenu', 'Create'),
                                'data-url' => Url::to(['/sections/session-management/create'])
                            ]);
                            ?>
                            <?php
                            echo yii\helpers\Html::button("<i class='fa fa-trash'></i>", [
                                'data-id' => $f['id'],
                                'data-parent_id' => Yii::$app->request->get('id', '0'),
                                'file_type' => $f['id'],
                                'data-action' => 'create',
                                'class' => 'btn btn-danger btnDeleteBySelect',
                                'title' => Yii::t('appmenu', 'Delete'),
                                'data-url' => Url::to(['/sections/session-management/create']),
                            ]);
                            ?> 

                        </span>
                        <i class="fa <?= $f['icon'] ?>"></i> <?= $f['name'] ?><br>
                        <small id="label_<?= $f['id'] ?>"><?= Yii::t('file', 'Image') ?></small>
                        <hr/>
                    </div>
                    <div class="box-body" id="panel-<?= $f['id'] ?>">
                        <div class="col-md-12">
                            <label><input type="checkbox" id="checkAll-<?= $f['id'] ?>" data-id="<?= $f['id'] ?>"> <?= Yii::t('section', 'Select All') ?></label>  
                            <div id="files_<?= $f['id'] ?>" data-id='<?= $f['id'] ?>'></div>
                            <?php \richardfan\widget\JSRegister::begin(); ?>
                            <script>
                                $("#checkAll-<?= $f['id'] ?>").click(function () {
                                    let id = $(this).attr('data-id'); 
                                    //$('#checkAll-' + id + ' input:checkbox').not(this).prop('checked', this.checked);
                                    
                                    setTimeout(function(){ 
                                        $('#checkAll-' + id).prop('checked', true); 
                                    },100);    
                                    $('#panel-' + id + ' input:checkbox').not(this).prop('checked', this.checked);
                                    if(this.checked == false){
                                        setTimeout(function(){ 
                                        $('#checkAll-' + id).prop('checked', false); 
                                    },100); 
                                    }
                                    return false;
                                });//Check All

                            </script>
                            <?php \richardfan\widget\JSRegister::end(); ?>
                        </div>
                    </div>                     
                    <div class="box-footer read-all">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <?=
                                Html::a(Yii::t('section', 'More...'), Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id=&filet_id={$f['id']}", [
                                    'id' => "btn-{$f['id']}",
                                    'data-action' => 'view-file',
                                    'class' => 'content-popup btnCall btn btn-default btn-block',
                                    'data-id' => $f['id'],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
        </div>
        <?php \richardfan\widget\JSRegister::begin(); ?>
        <script>

            get_form = function (url, params) {
                $('#<?= $modal ?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
                $('#<?= $modal ?>').modal('show');
                $.get(url, params, function (res) {
                    $('#<?= $modal ?> .modal-content').html(res);

                });
            }
            load_data = function () {
                let url = '<?= Url::to(['/sections/content-management/view-data-content'])?>'
                let content_id = "<?= Yii::$app->request->get('content_id') ?>";
                let select_id = "files_<?= $f['id'] ?>";

                let params = {content_id: content_id, type_id: "<?= $f['id'] ?>"};
                $('#' + select_id).html("<div>Loading...</div>");
                $.get(url, params, function (data) {
                    $('#' + select_id).html(data);
                });

                return false;

            }
            load_content_data = function () {
                let url = '<?= Url::to(['/sections/content-management/get-count-data'])?>'
                let content_id = "<?= Yii::$app->request->get('content_id') ?>";
                let select_id = "label_<?= $f['id'] ?>";

                let params = {content_id: content_id, type_id: "<?= $f['id'] ?>"};
                $('#' + select_id).html("<div>Loading...</div>");
                $.get(url, params, function (data) {
                    //console.log(data);
                    $('#' + select_id).html(data);
                });
                return false;

            }
           
            load_content_data();
            load_data();

        </script>
        <?php \richardfan\widget\JSRegister::end(); ?>
    <?php endif; ?>
<?php endforeach; ?> 


<?php
$modalf = 'file-modal';
echo yii\bootstrap\Modal::widget([
    'id' => $modalf,
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => false, 'keyboard' => false
    ],
    'options' => ['tabindex' => false]
]);
?>
<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('.btnCreateFile').on('click', function () {
        let id = $(this).attr('data-id');
        let content_id = '<?= Yii::$app->request->get('content_id', '') ?>';
        $('#<?= $modalf ?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#<?= $modalf ?>').modal('show');
        let url = '<?= Url::to(['/sections/file-management/upload-file'])?>';
        let file_type = $(this).attr('file_type');

        $.get(url, {id: id, file_type: file_type, content_id: content_id}, function (res) {
            $('#<?= $modalf ?> .modal-content').html(res);
        });
        return false;
    });
    
     $('.btnDeleteBySelect').click(function () {
               let id = $(this).attr('file_type');
                yii.confirm('<?= Yii::t('file', 'คุณต้องการลบรายการเหล่านี้หรือไม่?') ?>', function(){
               
                let url = '<?= Url::to(['/sections/file-management/delete-file'])?>';
               // console.log('#panel-', id);
                $('#panel-' + id + ' :checkbox:checked').each(function () {
                    let dataID = $(this).val();
                                                              console.log(dataID);
                                                              
                    if (!dataID) {
                        return;
                    }
                    if (dataID != "on") {
                        //yii.confirm('<?= Yii::t('app', 'คุณต้องการลบรายการเหล่านี้หรือไม่?')?>', function() {
                            $.post(url, {id: dataID}, function (result) {
                                <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
                                $('#img-' + dataID).remove();
                            });
                        //});
                       
                    }
                });

                });
                return false;
            });
</script>
<?php richardfan\widget\JSRegister::end(); ?>        


<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .box.box-primary {
        border: none;
        box-shadow: 0px 0px 1px #cacaca;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>
