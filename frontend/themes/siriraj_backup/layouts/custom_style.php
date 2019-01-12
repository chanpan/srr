<?php 
    $theme = common\models\Themes::findOne("1000");
    $bg_header = isset($theme['bg_header']) ? $theme['bg_header'] : '#f3ede1';
    $bg_menu = isset($theme['bg_menu']) ? $theme['bg_menu'] : '#F4F4F4';
    $bg_border_menu = isset($theme['bg_border_menu']) ? $theme['bg_border_menu'] : '#A9A9A9';
    $bg_menu_link = isset($theme['bg_menu_link']) ? $theme['bg_menu_link'] : '#1a1a1b';
    $bg_menu_link_hover = isset($theme['bg_menu_link_hover']) ? $theme['bg_menu_link_hover'] : '#fff';
    $bg_footer = isset($theme['bg_footer']) ? $theme['bg_footer'] : '#641a35';
    $bg_footer_txt = isset($theme['bg_footer_txt']) ? $theme['bg_footer_txt'] : '#fff';
    $bg_footer_txt = isset($theme['bg_footer_txt']) ? $theme['bg_footer_txt'] : '#fff';
    
    $color_logo_text = isset($theme['color_logo_text']) ? $theme['color_logo_text'] : '#000';
    $logo_image = isset($theme['logo_image']) ? $theme['logo_image'] : '#000';
?>

<?php appxq\sdii\widgets\CSSRegister::begin() ?>
<style>
    .off-white-bg {
        background: #fff;
        background: #fff;
        background: #f3f3f3 url(<?= "/images/open.jpg" ?>) no-repeat center top;
        background-size: cover;
        background-attachment: fixed;
    }
    .ptb-15{    
        padding: 0px 0;
        background: <?= $bg_header?>;
        background-size: cover;
        background-attachment: fixed;
    }
    
    
    /*navbar menu สีเนู*/
    .header-bottom.header-sticky{
        background:<?= $bg_menu?>;
    }
    /*สีขอบ*/
    .header-bottom-list>li>a{
        border-left: 1px solid <?= $bg_border_menu?>;
    }
    /*สีตัวหนังสือ*/
    .header-bottom-list>li>a, .header-bottom-list>li>ul.ht-dropdown li a{
        color: <?= $bg_menu_link?>;  
    }
    /*สีตัวหนังสือตอนเอาเมาส์ชี้*/
    .header-bottom-list li a:hover{
        color:<?= $bg_menu_link_hover?>;
        /*background: #b2b3b7;*/
    }
    
    
    /* footer */
    .footer-bottom{
        background: <?= $bg_footer?>;
    }
    .copyright-text.text-center>p{
        color:<?= $bg_footer_txt?>;
    }
    
    
    
    /*mobile*/
    .mean-container .mean-bar, .mean-container .mean-nav ul li a{
        background:<?= $bg_menu?>;
    }
    .mobile-menu::before, .mean-container .mean-nav ul li a{
        color: <?= $bg_menu_link?>;
    }
    .mean-container a.meanmenu-reveal{
        background: <?= $bg_menu?> none repeat scroll 0 0;
    }
    .mean-container .mean-nav ul li a{
        border-top: 1px solid #cccccc;
    }
    .mean-container .mean-nav ul li a:hover{
        background:<?= $bg_menu?>;
    }
    
    .bootstrap-select{
        font-size: 15px;
    }
    
    
    /*custom*/
    .bootstrap-dialog {
        /* background: blue; */
        padding-top: 60px;
        font-size: 20pt;
    }
    .carousel-caption { 
        right: 15%;
        bottom: 5px;
        color: #020202;
        background: #f3e4cabd;
        border-radius: 5px;
        width: 30%;
        margin: 0 auto;
    }
    
    .logo a {
        color: <?= $color_logo_text?>;
        font-size: 22pt;
        line-height: 30px;
        font-family: sans-serif;
    }
    .txt-logo-en a{
        font-size: 18pt;
        padding-left:5px;
    }  
    .input-group-addon {
        padding: 8px 15px;
        padding-right: 25px;
    }
    #UserProfile .control-label{text-align:left;}
    
    .setting-account{
        border-bottom: 1px solid gainsboro;
        padding: 15px;
    }
    .setting-account i{font-size:18pt;margin-right:10px;}
    div.required label.control-label:after {
        content: " *";
        color: red;
    }
    
    @media screen and (max-width: 768px)
    {
        .col-30 {
            width: 33.33%;
            /*margin: 0 auto;*/
            margin: 10px auto;
        }
        .col-100 {
            width: 100%;
            margin: 0 auto;
        }
        .pdl-0{padding-left: 0px;}
        .mb-10{margin-bottom:10px;}
        .col-md-9 , .col-md-8 , .col-md-3, .col-md-4 , .container{
            max-width: 100%;
        }
        .h-80{
            height:120px;
        } 
    }
    
    .cart-box>ul>li>a i{
        font-size: 30pt;
    }
    .header-bottom-list>li>a, .header-bottom-list>li>ul.ht-dropdown li a { 
        font-size: 16pt;
    }
    .ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button {
        font-family: Arial,Helvetica,sans-serif;
        font-size: 1.5em;
    }
    .pro-infos h4 {
        font-size: 14pt;
        text-align: center;
    }
</style>
<?php appxq\sdii\widgets\CSSRegister::end() ?> 


