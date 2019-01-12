<div class="col-md-12">
    <?php
    $type = backend\modules\sections\classes\JFiles::getTypeFile();
    ?>

    <form class="" role="search">
        <div class="input-group">
            <input type="hidden" name="search_param" value="all" id="search_param">         
            <input type="text" class="form-control" name="x" placeholder="ค้นหา">
            <div class="input-group-btn search-panel">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="border-radius:0;background: #fff;">
                    <span id="search_concept">เลือกประเภทไฟล์</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <?php foreach ($type as $t) { ?>    
                        <li data-id='<?= $t['id'] ?>'><a href='#<?= $t['name'] ?>' data-id='<?= $t['id'] ?>'><?= $t['name'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <span class="input-group-btn">
                <button class="btn btn-default  btn-search" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </form> 

</div>