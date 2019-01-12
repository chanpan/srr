<?php

use yii\helpers\Html;
use frontend\components\NavBar;
use yii\bootstrap\Nav;

\frontend\components\AppComponent::navbarRightMenu();
?>

<header class="main-header">

    <?php
    NavBar::begin([
        'id' => 'main-nav-app',
        'brandLabel' => 'SIRIRAJ MUSEUM',
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'page-container navbar navbar-inverse navbar-fixed-top',
        ],
    ]);

//echo Nav::widget([
//    'options' => ['class' => 'navbar-nav navbar-left'],
//    'items' => [        
//        ['label' => Yii::t('appmenu','ห้องความรู้'), 'icon' => 'file-code-o', 'url' => ['/knowledges/section'],
//            'active'=>(Yii::$app->controller->module->id == 'knowledges' && Yii::$app->controller->id == 'section') ? true : false],
//    ]
//]);


    echo \yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => isset(Yii::$app->params['navbarR']) ? Yii::$app->params['navbarR'] : [],
    ]);
    echo '<div class="navbar-text pull-right">';
    echo \lajax\languagepicker\widgets\LanguagePicker::widget([
        'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
        'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
    ]);
    echo '</div>';

    NavBar::end();
    ?>    
</header>
<?php
$this->registerJs("
        $('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).attr('href').replace('#','');
		var concept = $(this).text();
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #search_param').val(param);
	});
    ");
?> 
<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
/*    @media (min-width: 768px){
        .content-header>.breadcrumb {
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
    } 

    .navbar-nav > li > .dropdown-menu {
        margin-top: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        background: #276b92;
        border: 1px solid #3c8dbc;
    }
    .dropdown-menu>li>a:hover {
        background-color: #225979;
        color: #333;
    }
    .box.box-primary {
        border: none;
        box-shadow: 0px 0px 5px #a7a7a7;
    }
    @media (min-width: 768px){
        #items-views {
            margin-left: 250px;
            margin-top: 25px;
        }
        .list-view .item a.media { 
            font-size: 14px;
        }
        .items-sidebar.navbar-collapse{
            width: 255px;
        } 

    } 
    .sidebars{
        background:#fff;
        padding:10px;
    }

    .items-sidebar.navbar-collapse{
            border-right:1px solid #dedede;
            background-color: #34393d;
            background-image: url(<?= "/images/bg.jpg"?>);
            background-attachment: fixed;
            background-size: contain;
    }
    

    .navbar-inverse {
        background-color: #3867d6;
        box-shadow: 0px 2px 2px #00000057;
        border-color: #24678e;
    }
    .btn-primary {
        background-color: #3867d6;
        border-color: #2e66ea;
        box-shadow: 0px 2px 2px #00000057;
    }
    .btn-primary:hover {
        background-color: #2957c5;
        border-color: #3867d6;
    }
    .box-header {
        background: #f5f5f5;
        border-bottom: 1px solid #d1d1d2;
    }
    
    .content-wrapper{
        background: #fff;
        background: #ededed;
    }
    .list-view .item a.media { 
        border-bottom: 1px solid #3e3e3e3b;
        color: #fff;
        font-weight: bold;
    }
    .list-view .item a.media:hover {
        text-decoration: none;
        background-color: #4e4e4e;
        color: #fff;
         opacity: 0.5; 
    }
    .box.box-primary {
        box-shadow: 0px 0px 5px #a7a7a7;
         
    }
    .box-header.with-border{
        color: #333;
        background-color: #f5f5f5;
        border-color: #ddd;
    }
    .product-list-in-box>.item {
        border-bottom: 1px solid #2a334c38;
        border-bottom-style: dashed;
    }
    .item a{color:#333;}
    .navbar-inverse .navbar-toggle:hover, .navbar-inverse .navbar-toggle:focus{
        background-color: #6200ee;
    }
    
    .box-footer a{
        color:#fff;
    }
    .box-header>.fa, .box-header>.glyphicon, .box-header>.ion, .box-header .box-title{
        font-size:14px;
        font-weight: bold;
    }
    .products-list .product-info{
        font-size:14px;
        line-height: 35px;
    }
    
    .panel-default > .panel-heading {
        color: #fff;
        background-color: #3867d6;
        border-color: #ddd;
    }
    @media screen and (max-width: 768px){
        section {
            padding: 0em 0;
        }
        #items-views {
            margin-top: 30px;
        }
    }
    .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus{
            background-color: #3867d6;
    }
    .navbar-nav > li > .dropdown-menu{
        background-color: #3867d6;
    }
    .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
        color: #fff;
        background-color: #2b56bb;
        padding-top: 15px;
    }*/
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>
 