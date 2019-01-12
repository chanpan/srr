<div class="col-md-10 col-md-offset-1">
    <?php
    $type = frontend\modules\sections\classes\JFiles::getTypeFile();
    ?>

    <form class="" role="search" action="" id="formSearch">
        <div class="input-group">
            <input type="hidden" name="search_param" value="<?= isset($fileType) ? $fileType['id'] : 'all'?>" id="search_param">         
            <input type="text" class="form-control" name="txtsearch" id="txtsearch" placeholder="ค้นหา" value="<?= $txtsearch?>">
            <div class="input-group-btn search-panel">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="border-radius:0;background: #fff;">
                    <span id="search_concept"><?= isset($fileType) ? $fileType['name'] :  Yii::t('section', 'Select Type') ?></span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <?php foreach ($type as $t) { ?>    
                    <li class="select_type" data-id='<?= $t['id'] ?>'><a href='#<?= $t['name'] ?>' data-id='<?= $t['id'] ?>'><?= $t['name'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <span class="input-group-btn">
                <button class="btn btn-default  btn-search" type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </form> 

</div>
<?php 
    $this->registerCss("
            .dropdown-menu>li>a:hover {
                background-color: #225979;
                color: #fff !important;
            }
        ");
?>
<?php    richardfan\widget\JSRegister::begin(); ?>
<script>
    $('#formSearch').on('submit', function(){
        let type_id = $('#search_param').val();
        let txtsearch = $('#txtsearch').val();
        let params = {type_id:type_id, txtsearch:txtsearch};
        let url = "<?= yii\helpers\Url::to(['/sections/session-management/search?type_id='])?>"+type_id+"&txtsearch="+txtsearch;
        //window.open(url,'_blank');
        location.href = url;
        
        return false;
    });
    $('.select_type').on('click', function(){
        let id = $(this).attr('data-id');
        $('#search_param').val(id);
       
    });
    
</script>
<?php    richardfan\widget\JSRegister::end();?>