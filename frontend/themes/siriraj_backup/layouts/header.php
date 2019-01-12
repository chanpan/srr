<?php

use yii\helpers\Url;
use yii\helpers\Html;

$email = \backend\modules\cores\classes\CoreOption::getParams("email", "e");
$tel = \backend\modules\cores\classes\CoreOption::getParams("tel", "e");
$website = \backend\modules\cores\classes\CoreOption::getParams("website", "e");
?>

<header> 
    <div class="header-middle ptb-15">
        <?= $this->render("_search", ['directoryAsset' => $directoryAsset]) ?>    
        <div class="header-bottom  header-sticky">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-xl-12 col-lg-12 col-md-12 ">
                        <nav class="d-none d-lg-block">
                            <ul class="header-bottom-list d-flex">
                                <li><a href="/"><i class="fa fa-home"></i> <?= Yii::t('appmenu', 'Home') ?></a></li>
                                <li><a href="/site/about"><?= Yii::t('appmenu', 'About Us') ?></a></li>
                                <li><a href="/site/contact"><?= Yii::t('appmenu', 'Contact Us') ?></a></li>
                                <?php if (Yii::$app->user->isGuest): ?> 
                                    <li><a href="/account/sign-in/login"><?= Yii::t('appmenu', 'Login') ?></a></li>
                                    <li><a href="/account/sign-in/signup"><?= Yii::t('appmenu', 'Register'); ?></a></li>
                                <?php endif; ?>
                                <li style="    line-height: 45px;position: absolute; right: 0;margin-top: 5px;;">
                                    <?php
                                    echo \lajax\languagepicker\widgets\LanguagePicker::widget([
                                        'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
                                        'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
                                    ]);
                                    ?> 
                                </li> 
                            </ul>
                        </nav>
                        <div class="mobile-menu d-block d-lg-none">
                            <nav>
                                <ul>
                                    <li><a href="/"><i class="fa fa-home"></i> <?= Yii::t('appmenu', 'Home') ?></a></li>
                                    <li><a href="/site/about"><?= Yii::t('appmenu', 'About Us') ?></a></li>
                                    <li><a href="/site/contact"><?= Yii::t('appmenu', 'Contact Us') ?></a></li>
                                    <?php if (Yii::$app->user->isGuest): ?> 
                                        <li><a href="/account/sign-in/login"><?= Yii::t('appmenu', 'Login') ?></a></li>
                                        <li><a href="/account/sign-in/signup"><?= Yii::t('appmenu', 'Register'); ?></a></li>
                                    <?php endif; ?>
                                    <li class="text-center">
                                        <?php
                                        echo \lajax\languagepicker\widgets\LanguagePicker::widget([
                                            'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
                                            'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
                                        ]);
                                        ?> 
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Row End -->
            </div>                
        </div>
        <?php if ($slide == '1'): ?>
            <?php
            $images = \backend\modules\sections\classes\JContent::getImage();
            $imagesMost = \backend\modules\sections\classes\JContent::getImageMost();
            //\appxq\sdii\utils\VarDumper::dump($imagesMost);
            ?>
            <div class="container"> 
                <div class="" style="">    
                    <div class="col-md-9 mt-15">
                        <div class="container">
                            <?php foreach ($images as $k => $image): ?>
                                <div class="col-xs-4 col-100 over-hidden mt-10 pdl-0">
                                    <a href="/sections/section?id=1534738588018029900" style="color:#000;"> 
                                        <img class="mb-10"  src="<?= "{$image['view_path']}/{$image['name']}" ?>"  alt="<?= $image['detail'] ?>">
                                    </a>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-3 text-center" style="">
                        <h3 class="text-center pd-10"><?= Yii::t('section', 'Most Popular') ?></h3>
                        <div class="clearfix"></div>
                        <div class="container">
                            <?php foreach ($imagesMost as $k => $image): ?>

                            <div class="col-xs-6 over-hidden h-80 col-30">
                                <a href="/sections/content-management/view-file?content_id=<?= $image['content_id'] ?>&file_id=<?= $image['id'] ?>&filet_id=<?= $image['file_type'] ?>" style="color:#000;" > 
                                    <img  class="height-100" src="<?= "{$image['file_path']}/thumbnail/{$image['file_view']}" ?>"  >

                                </a>
                            </div>

                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>     
            <?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
            <style>
                .col-xs-4.col-100.over-hidden {
                    overflow: hidden;
                }
                .pd-10{padding:10px;}
                .h-80{
                    height: 80px;
                    overflow: hidden;
                    margin-bottom: 10px;
                }
                .over-hidden{overflow: hidden;}
                .height-100{height:100%;} 
                 

            </style>
            <?php \appxq\sdii\widgets\CSSRegister::end(); ?>
        <?php endif; ?>

        <?php if (isset($_GET['txtsearch'])): ?>
            <div style="
                 margin-top: 0px;
                 height: 115px;
                 padding-top: 0px;
                 background: url(<?= Url::to('@web/images/landing1.jpg') ?>);
                 padding-top: 210px;
                 height: 500px;
                 background-size: cover;
                 background-repeat: no-repeat;
                 /* background-position: center; */

                 ">
                 <?php else: ?>
                <div style="margin-top:0;height:115px;padding-top: 30px;background:#37373a;">    
                <?php endif; ?>    
                <div class="col-md-8 col-md-offset-2">
                    <?php
                    $type = frontend\modules\sections\classes\JFiles::getTypeFile();
                    ?>
                    <?= $this->render("_form", ['type' => $type]) ?>     
                </div>
                <div class="clearfix" style=""></div>
                <!-- Cart Box End Here -->
            </div>         
            <?php if ($slide == '10'): ?>

                <div class="slider_box" style="background: #f3f3f3;">            
                    <div class='container-fluid'>
                        <?php
                        $images = \backend\modules\sections\classes\JContent::getImage();
                        ?>
                        <div>

                            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-ride="carousel" data-interval="5000000000" data-pause="hover">


                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">

                                    <?php foreach ($images as $k => $image): ?>
                                        <?php if ($k == 0): ?>
                                            <div class="item active">
                                                <a href="<?= $image['url'] ?>">
                                                    <img src="<?= "{$image['view_path']}/{$image['name']}" ?>"  alt="<?= $image['detail'] ?>">
                                                </a><?php if ($image['detail']): ?>
                                                    <div class="carousel-caption"> 
                                                        <p><?= $image['detail'] ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div> 
                                        <?php else: ?>
                                            <div class="item">
                                                <a href="<?= $image['url'] ?>">
                                                    <img src="<?= "{$image['view_path']}/{$image['name']}" ?>"  alt="<?= $image['detail'] ?>">
                                                </a>
                                                <?php if ($image['detail']): ?>
                                                    <div class="carousel-caption"> 
                                                        <p><?= $image['detail'] ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div> 
                                        <?php endif; ?>
                                    <?php endforeach; ?> 

                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>




                    </div>
                </div>

                <?php appxq\sdii\widgets\CSSRegister::begin(); ?>
                <style>
                    .slider_box {
                        background: transparent;
                        padding-bottom: 30px;
                    }
                    .carousel-control.left, .carousel-control.right{
                        background: transparent;
                    }
                    .slider_box{
                        padding-bottom: 0px;
                        text-align: center;
                        margin: 0 auto;
                    }
                    .carousel-inner > .item > img, .carousel-inner > .item > a > img {
                        margin:0 auto;
                    }
                    @media screen and (max-width:768px){
                        .carousel-caption{
                            display:none;
                        }
                    }

                </style>
                <?php appxq\sdii\widgets\CSSRegister::end() ?>
            <?php endif; ?>
            </header>