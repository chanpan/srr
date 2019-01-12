<?php 
    use yii\helpers\Url;
    $cart = isset(Yii::$app->session["cart"]) ? count(Yii::$app->session["cart"]) : 0;
    ///sections/content-management/view-file?content_id=1536226767074797500&file_id=1538478070046184200&filet_id=2
    //appxq\sdii\utils\VarDumper::dump($cart);
    
    $storage = Yii::getAlias('@storageUrl');
?>
<header>
<a href='<?= Url::to(['/'])?>'>
    <div class="container">
        <div class="col-md-1 text-center">
            <img id="logo" src="<?= $storage?>/images/logosirirajweb3.png" class="img img-responsive"/>
        </div>
        <div class="col-md-7 logo-text">
            <h3>คลังสมบัติของพิพิธภัณฑ์ศิริราช</h3>
            <h3>Siriraj Museum Treasure</h3>
        </div>
        <div class="col-md-3 text-center"> 
             <?php if (!Yii::$app->user->isGuest): ?> 
            <a href="<?= Url::to(['/account/default/settings'])?>">
                ยินดีต้อนรับ  : <?= Yii::$app->user->identity->userProfile->firstname. ' '.Yii::$app->user->identity->userProfile->lastname;?>
            </a>
            <?php endif; ?>
        </div>
    </div></a>
</header>
<div class="container">
        <div class="navbar-menu" id="navbar-desktop" >
            <ul>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= $this->render('navbar-user', ['cart'=>$cart]) ?>
                <?php else: ?>
                    <?= $this->render('navbar-guest') ?>
                <?php endif; ?>

            </ul>
        </div>
        <div id="navbar-mobile" >
            <?= $this->render('navbar-mobile', ['cart'=>$cart])?>
        </div>
    
    <?php if(Yii::$app->user->isGuest):?>
        <?php 
            $modalId = 'modal-mark';
            echo yii\bootstrap\Modal::widget([
                'id'=>$modalId,
                'size'=>'modal-xxl',
                'options'=>['tabindex' => false]
           ]);
        ?>
        <?php richardfan\widget\JSRegister::begin();?>
            <script>
                $('.nav-cart-popup').on('click', function(){
                    let url='<?= Url::to(['/site/alert'])?>';
                    $('#<?= $modalId?>').modal('show');
                    $('#<?= $modalId?> .modal-content').html('<i class="fa fa-spinner fa-spin fa-fw"></i>');
                    $.get(url,function(data){
                        $('#<?= $modalId?> .modal-content').html(data); 
                    });
                    
                    return false;
                });
            </script>
        <?php richardfan\widget\JSRegister::end();?>
    <?php endif;?>
    <?php appxq\sdii\widgets\CSSRegister::begin()?>
    <style>
        .pro-content .pro-infos h2 {
            padding: 5px;
        }
        @media screen and (max-width: 769px) {
            .navbar-menu-center{
                margin-left:10px;
            }
            #navbar-mobile{
                display: block;
            }
            #navbar-desktop{
                display: none;
            }
            .container {
                padding-right: 0px;
                padding-left: 0px;
            }
            .cd-breadcrumb li::after, .cd-multi-steps li::after {
                display: inline-block;
                content: '\00bb';
                margin: 0px 0.0em;
                color: #959fa5;
            }
            .cd-breadcrumb li > *, .cd-multi-steps li > * {
                font-size: 14pt;
            }
            .cd-breadcrumb.custom-separator li::after, .cd-multi-steps.custom-separator li::after {
                margin-top: -5px;
            }
            .pro-content .pro-infos h2 {
                font-size: 16pt;
            }
            .image-sliders {
                height: 65px;
            }
            .single-product {
                /* height: 170px; */
                margin-top: 10px;
            }
            .header-section{
                font-size:16pt;
            }
            .pro-content{
                height: 95px;
                overflow: hidden;
            }
            h1 {
                font-size: 18pt;
            }
.pro-content { 
    margin-top: 30px;
}
.menu-height{
        width: 100px;
}
        }
        @media screen and (min-width: 768px) {
            #navbar-desktop{
                display: block;
                //float: left;
                margin-left: 163px;
            }
        .navbar-menu-center{
            margin-left:100px;
        }
            #navbar-mobile{display: none;}
            .panel-title {
                font-size: 16pt;
            }
        }
    </style>
    <?php appxq\sdii\widgets\CSSRegister::end()?>
    <div class="clearfix"></div>
    <div class="col-md-6 col-md-offset-4 col-xs-offset-2">
        <div class="navbar-menu-center">
            <ul>
                <?php if(empty($layoutSecond)):?>
                    <li ><a href="#" id="btnHighlight"><?= Yii::t('section', 'HIGHLIGHT')?></a></li>
                    <li ><a href="#" id="btnTopSearch"><?= Yii::t('section', 'TOP SEARCH')?></a></li>
                <?php endif; ?>
                
            </ul>
        </div>
    </div>
</div>


<!-- Slider Image -->
<?php if(empty($layoutSecond)):?>
<div id="slideer-image"></div>  
<?php endif; ?>
<!-- Form Search -->      
<div id="form-search">
    <?php echo $this->render('form-search')?>
</div> 

<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    var windowWidth = jQuery(window).width();
    //console.log(windowWidth);
    if(windowWidth > 769){
        //$('#navbar-desktop').show();
        //$('#navbar-mobile').hide();
    }else{
        //$('#navbar-desktop').hide();
        //$('#navbar-mobile').show();
    }
    
    
    function loadHighlight(){
       let url = '<?= Url::to(['/site/highlight'])?>';
       
       $('#btnHighlight').addClass('nav-active-right');
        $('#btnTopSearch').removeClass('nav-active-left');
       
       loadSlideImage(url);
       return false;
    }
    function loadSlideImage(url){
        $('#slideer-image').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-fw"></i></div>');
        $.get(url,function(data){
            $('#slideer-image').html(data); 
        });
        return false;
    }
    $('#btnHighlight').on('click', function(){
        loadHighlight();
        return false;
    }); 
    $('#btnTopSearch').on('click', function(){
        $('#btnHighlight').removeClass('nav-active-right');
        $('#btnTopSearch').addClass('nav-active-left');
        let url = '<?= Url::to(['/site/top-search'])?>';
        loadSlideImage(url);
       return false;
    }); 
    
    loadHighlight();
</script>
<?php richardfan\widget\JSRegister::end(); ?>

<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .space{
       padding: 0;
        width: 20px;
    }
    .nav-login{
        padding:0px;
            padding: 0px;
    /* background: blue; */
    margin-right: -12px;

    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
