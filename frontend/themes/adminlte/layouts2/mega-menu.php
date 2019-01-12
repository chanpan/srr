<?php

use yii\helpers\Html;

\janpan\jn\assets\JMegaMenuAssets::register($this);
?>
<div class="wsmenucontainer clearfix navbar-fixed-top">
    <div id="overlapblackbg"></div>
    <div class="wsmobileheader clearfix"> <a id="wsnavtoggle" class="animated-arrow"><span></span></a> <a class="smallogo"><img src="./image/sml-logo.png"  alt="" /></a> <a class="callusicon" href="tel:123456789"><span class="fa fa-phone"></span></a> </div>

    <div class="headerfull">
        <!--Main Menu HTML Code-->
        <div class="wsmain">
            <div class="smllogo">
                <a href="#" >
                    <?= Html::img('@web/images/logo.png', ['style' => 'width: 45px;']); ?>
                </a>
            </div>
            <nav class="wsmenu clearfix ">
                <ul class="mobile-sub wsmenu-list">                   
                    <li class="wssearchbar clearfix">
                        <form class="topmenusearch">
                            <input placeholder="Search Product By Name, Category...">
                            <button class="btnstyle"><i class="searchicon fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </li>
                    <li><a href="#" class="navtext"><span></span> <span>ห้องความรู้ </span></a>
                        <div class="megamenu clearfix">
                            <div class="container-fluid">
                                <div class="row mega-menu-main">
                                     <?php 
                                        $root = \frontend\components\AppComponent::sectionRoot();
                                     ?>
                                    <?php foreach($root as $r):?>
                                    <a href="/knowledges?parent_id=<?= $r['id']?>" data-id="<?= $r['id']?>">
                                        <div class="col-md-6 mega-menu-items">
                                            <div class="root-icon"><i class="<?= $r['icon']?>"></i></div>
                                            <div class="root-content">
                                                <?= $r['name']?>
                                            </div>
                                        </div>
                                    </a>    
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </li>                    
                    <li class="wscarticon clearfix"> <a href="#"><i class="fa fa-shopping-basket"></i> <em class="roundpoint">8</em><span class="mobiletext">Shopping Cart</span></a> </li>
                    <li class=""> 
                        <a href="#" class=""><span></span> <span>Half menu</span></a>                         
                    </li>
                    <li class="wsshopmyaccount clearfix">
                        <a href="#" class="wtxaccountlink">
                            <i class="fa fa-align-justify"></i>My Account <i class="fa  fa-angle-down"></i>
                        </a>
                        <ul class="wsmenu-submenu">
                            <li><a href="#"><i class="fa fa-black-tie"></i>View Profile</a></li>
                            <li><a href="#"><i class="fa fa-heart"></i>My Wishlist</a></li>
                            <li><a href="#"><i class="fa fa-bell"></i>Notnification</a></li>
                            <li><a href="#"><i class="fa fa-question-circle"></i>Help Center</a></li>
                            <li><a href="#"><i class="fa fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <!--Menu HTML Code-->
    </div> 
</div>
<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .mega-menu-main{
        height: 400px;
        overflow-y: auto;
    }
    .mega-menu-items{
        display: flex;
        flex-direction: row;
        margin-top: 10px;
    }
    .root-content {
        padding: 10px;
        /*border: 1px solid beige;*/
        width: 100%;
    }
    .root-icon {
        background: #ecf0f5;
        width: 50px;
        text-align: center;
        line-height: 43px;
        border-radius: 3px;
        /*border: 1px solid gray;*/
    }
    .row.mega-menu-main a {
        color: #333;
    }
    .content-header>.breadcrumb {
        float: none;
        background: transparent;
        margin-top: -5px;
        margin-bottom: 16px;
        font-size: 14px;
        padding: 9px 5px 5px 10px;
        position: absolute;         
        right: 10px;
        border-radius: 2px;         
        background: #dcdee0;
        left: 15px;
        border-radius: 3px;
        display: block;
    }
    .content-header{
        margin-bottom: 40px;
    }
</style>
<?php  \appxq\sdii\widgets\CSSRegister::end();?>