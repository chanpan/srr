<?php 
    use yii\helpers\Url;
    $this->title = Yii::t('_app', 'Dashboard');
?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/sections/session-management'])?>" style="text-decoration: none;color:#000;">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('_app', 'Files All')?></span>
                    <span class="info-box-number"><?= count($file)?><small> <?= Yii::t('_app', 'Items')?></small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
       </a>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/user/index'])?>" style="text-decoration: none;color:#000;">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('_app','Users')?></span>
                <span class="info-box-number"><?= count($user)?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
            </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/viewcountermanagement/view-count'])?>" style="text-decoration: none;color:#000;">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-eye"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('_app','Traffic statistics')?></span>
                <span class="info-box-number"><?= count($view)?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
            </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>
    

    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/order/order-management'])?>" style="text-decoration: none;color:#000;">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('_app','Request information')?></span>
                <span class="info-box-number"><?= count($order)?> <?= Yii::t('_app', 'Items')?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
            </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    
    <!-- /.col -->
</div>


<div class="row">
    <div class="col-md-6">
        <div>
          <div class="box">
            <div class="box-header with-border">
<h3 class="box-title"><?= Yii::t('_app','Traffic statistics')?> <?= Yii::t('_app','Year')?> <?= date('Y')?>   <a href="<?= Url::to(['/viewcountermanagement/view-count'])?>"><?= Yii::t('_app','All')?></a></h3> 
            </div> 
            <div class="box-body" style="">
                <div id="view-traffic"></div>
                <?php \richardfan\widget\JSRegister::begin();?>
                    <script>
                        function getTraffic(){
                           let url = '<?= Url::to(['/viewcountermanagement/view-count/preview?year='])?><?= date('Y')?>&month=0&print=0';
                            $('#view-traffic').html(`<div class='text-center'><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i></div>`)
                            $.get(url, function(data){
                              setTimeout(function(){
                                  $('#view-traffic').html(data); 
                                  $('.btnPrint').remove();  
                              },500);
                              
                           });
                        }
                        getTraffic();
                    </script>
                <?php \richardfan\widget\JSRegister::end();?>
            </div> 
          </div>
          <!-- /.box -->
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
<h3 class="box-title"><?= Yii::t('_app','Report Download')?> <?= Yii::t('_app','Year')?> <?= date('Y')?> <a href="<?= Url::to(['/viewcountermanagement/view-count/report-download'])?>"><?= Yii::t('_app','All')?></a></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="report-download"></div>
                <?php \richardfan\widget\JSRegister::begin();?>
                    <script>
                        function getReportDownload(){
                           let url = '<?= Url::to(['/viewcountermanagement/view-count/report-download-preview?year='])?><?= date('Y')?>&month=0&print=0';
                            $('#report-download').html(`<div class='text-center'><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i></div>`)
                            $.get(url, function(data){
                              setTimeout(function(){
                                  $('#report-download').html(data); 
                                  $('#btnPrint').remove();  
                              },500);
                              
                           }).fail(function(err){
                               $('#report-download').html("Load data error"); 
                           });
                        }
                        getReportDownload();
                    </script>
                <?php \richardfan\widget\JSRegister::end();?>
            </div>
            
          </div>
    </div>
</div>


 

<?php \richardfan\widget\JSRegister::begin(); ?>
<script>
    function setImageToText(){
       let url = '<?= Url::to(['/site/image-to-text'])?>'; 
        $.get(url, function(data){
        });
    }
    setImageToText();
</script>
<?php \richardfan\widget\JSRegister::end(); ?>
