<?php 
    
    janpan\jn\assets\jqueryui\JQueryUiAssets::register($this);
    //\appxq\sdii\utils\VarDumper::dump($type);
?>

<?php 
    $theme = common\models\Themes::findOne("1000");     
    $logo_image = isset($theme['logo_image']) ? $theme['logo_image'] : '#000';
?>
 
<div class="container">
    <div class="row align-items-center no-gutters">
            <div class="col-lg-1 col-md-12">
                <div class="logo mb-all-30">
                    <?php
                        $model = \common\models\Themes::findOne('1000');
                        $initImage = '/images/logosirirajweb3.png';
                        if($model->logo_image){
                            $imageArr = appxq\sdii\utils\SDUtility::string2Array($model->logo_image);
                            $initImage = "{$imageArr['path']}/{$imageArr['name']}";
                        }
                        
                    ?>
                    <a href="/"><img src="<?= $initImage?>" alt="logo-image" style="width: 110px; padding-right: 15px;padding-top: 15px;"></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="logo mb-all-30">
                    
                        <div class='txt-logo'>
                            <div class="txt-logo-th"><a href="/">คลังสมบัติของของพิพิธภัณฑ์ศิริราช</a></div>
                            <div class="txt-logo-en"><a href="/">Siriraj Museum Treasure</a></div>
                        </div> 
                    
                </div>
            </div>           
            
            <?php if (!Yii::$app->user->isGuest): ?>
                <?php echo $this->render("_nav_right")?> 
            <?php endif; ?>
            
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div> 
<div class="clearfix" style="margin-bottom: 20px;"></div>

<?php 
   $controllerID = Yii::$app->controller->id ;
   $actionID = Yii::$app->controller->action->id;
   //\appxq\sdii\utils\VarDumper::dump($actionID);
?>
<?php    richardfan\widget\JSRegister::begin(); ?>
<script>
    var select_type_search=0;
    $('#select-type-search').on('change', function(){
       let value = $(this).val();
       select_type_search = value;        
    });
    $('#formSearch').on('submit', function(){
        let type_id = select_type_search;
        let txtsearch = $('#text_search_params').val();
        let params = {type_id:type_id, txtsearch:txtsearch};
        //console.log(params);return false;
        let url = "/sections/session-management/search?type_id="+type_id+"&txtsearch="+txtsearch;
        let actionID = "<?= $actionID?>";
        
        if(actionID == "search"){
           window.open(url,'_parent');
        }else{
            window.open(url,'_blank');  
        }
       
        //location.href = url;
        
        return false;
    });
    $('.select_type').on('click', function(){
        let id = $(this).attr('data-id');
        $('#search_param').val(id);
       
    });
    
</script>
<?php    richardfan\widget\JSRegister::end();?>

