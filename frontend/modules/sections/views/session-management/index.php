<?php     
    use yii\bootstrap\Html;    
    \janpan\jn\assets\ListdataAsset::register($this);
    \janpan\jn\assets\EzfToolAsset::register($this);
    $this->title= Yii::t('section', ($title != '') ? $title : 'Session'); 
    if($breadcrumb){        
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);
    }
    $data_id = isset($_GET['id']) ? $_GET['id'] : $content_section['id'];
    $section_obj = \common\models\Sections::findOne($data_id);  
    $name_str = backend\modules\sections\classes\JFiles::lengthName($section_obj['name'], 18);
?>  

<section id="items-side" class="items-sidebar navbar-collapse collapse" role="complementary" >
    <div id="items-side-scroll" class="row">
        <div class="col-md-12">
            <?php if(!isset($_GET['id'])):?>  
            <div class="sidebar-nav-title sidebars">
            <?php else:?>
                <div class=" sidebar-nav-title ">
            <?php endif; ?>    
                <?php if(!isset($_GET['id'])):?>                
                    <?= \yii\helpers\Html::img('/images/logosirirajweb3.png', 
                            ['class' => 'img img-responsive', 'style'=>'width:80px;margin: 0 auto;']) ?>
                <?php else:?>
                <div style="padding:10px;border-bottom: 1px solid #1b1b1b63;">      
                    <h5 style="color:#ddd;"><?= "<i class='fa {$section_obj['icon']}' style='font-size: 20pt; margin-right: 10px;'></i> {$name_str}"?></h5>                     
                        <?php
                        if (isset($_GET['id'])) {
                            echo Html::a('<i class="fa fa-home" style="font-size: 20pt; margin-right: 10px;"></i> Home', ['/sections/session-management'], ['class' => 'link', 'style' => 'color:#b9b9bc']);
                        }
                        ?>
           
                </div>
                <?php endif; ?>
                 
            </div> 
            <div>
                 <?= $this->render('left-content',[
                    'dataProvider'=>$dataProvider, 
                    'data_id'=> isset($_GET['id']) ? $_GET['id'] : $content_section['id'], 
                ]);?>
            </div>
        </div>
    </div>
</section>
<section id="items-views" role="complementary" >
    <div class="row"> 
        <?php
            echo $this->render('right-content',[
                'contentProvider'=>$contentProvider, 
                'data_id'=> $data_id, 
                'parent_id'=>$content_section['id'],
                'public'=>$public,
                'content_section'=>$content_section,
            ]    
        );?>    
    </div>
    
</section>
<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
    $('.page-column').addClass('items-views');    

    itemsSidebar();

    $('#main-nav-app .navbar-header').append('<a class="a-collapse glyphicon glyphicon-th-list navbar-toggle" data-toggle="collapse" data-target="#items-side">&nbsp;</a>');

    $('#favorite-form-manager').click(function(){
        var url = $(this).attr('data-url');
        modalEzform(url);
        return false;
    });
    
    $('#modal-ezform-favorite').on('hidden.bs.modal', function (e) {
        location.reload();
    });
    
    function modalEzform(url) {
    $('#modal-ezform-favorite .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-ezform-favorite').modal('show')
    .find('.modal-content')
    .load(url);
}

    function  getHeight() {
        var sidebarHeight = $(window).height() - 51; //- $('.header').height()        
        if ($('body').hasClass("page-footer-fixed")) {
            sidebarHeight = sidebarHeight - $('.footer').height();
        }
        return sidebarHeight;
    }

    function  itemsSidebar() {
        var itemside = $('#items-side-scroll');
//         if ($('.page-sidebar-fixed').length === 0) {             
//            return;
//        }
        if ($(window).width() >= 992) {
            var sidebarHeight = getHeight();
            
            itemside.slimScroll({
                size: '7px',
                color: '#a1b2bd',
                opacity: .8,
                position: 'right',
                height: sidebarHeight,
                allowPageScroll: false,
                disableFadeOut: false
            });
        } else {
            if (itemside.parent('.slimScrollDiv').length === 1) {
                itemside.slimScroll({
                    destroy: true
                });
                itemside.removeAttr('style');
                $('.items-sidebar').removeAttr('style');
            }
        }

    }

</script>
<?php \richardfan\widget\JSRegister::end(); ?>


    
    
 
 

<?php 
    $modal = "modal-contents";
?>
<?php \richardfan\widget\JSRegister::begin();?>

<script>
   $('.btnCall').on('click', function(){
       let id       = $(this).attr('data-id');
       let url      = $(this).attr('data-url');
       let action   = $(this).attr('data-action');
       let parent_id = $(this).attr('data-parent_id'); 
       let params   = {id:id, parent_id:parent_id};
       if(action == 'delete'){
           delete_form(url , id);
       }else{
           get_form(url , params); 
       }      
       return false; 
   });
   get_form=function(url , params){
       $('#<?= $modal?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
       $('#<?= $modal?>').modal('show');
       $.get(url, params, function(res){
           $('#<?= $modal?> .modal-content').html(res);
       });
   } 
   delete_form=function(url, id){
        bootbox.confirm('<?= Yii::t('user', 'Confirm Delete?') ?>', function(){
            $.post(url, {id:id}, function(result){
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
                setTimeout(function(){
                    location.reload();
                },1000);
            });
        });   
    return false;
   }

   
</script>
<?php \richardfan\widget\JSRegister::end();?>

<?php 
    if(!$data_id){
        //appxq\sdii\utils\VarDumper::dump($data_id);
        $this->registerCss("
            @media (min-width: 768px){
                #items-views {                    
                    margin-top:-25px;
               } 
            }
            .dropdown-menu>li>a:hover {
                background-color: #225979;
                color: #fff;
            }
        ");
    }else{
        //appxq\sdii\utils\VarDumper::dump($data_id);
        $this->registerCss("            
            .content-header>.breadcrumb{
                right: 12px;
                left: 361px;
                top: 60px;
                box-shadow:none;
                padding: 8px 15px;
                margin-bottom: 20px;
                list-style: none;
                border-radius: 4px;
                border: 1px solid #e7e7e7; 
                font-size: 12pt;
                background-color: #f8f8f8;
                float: none;
            }
            @media screen and (max-width: 768px){
                .content-header>.breadcrumb{
                    left: 0px;
                }
            }
            @media (min-width: 768px){
                .content-header>.breadcrumb {          
                    left: 250px;
                    margin-left: 12px;
              }
            }
        ");
    }
?> 

<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
   
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>

