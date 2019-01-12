<?php

use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\log\Logger;
use backend\models\Log;
Yii::$app->name = 'SIRIRAJ';
/* @var $this \yii\web\View */
$path = Yii::getAlias('@storageUrl');
$logo =  \yii\helpers\Html::img("{$path}/images/logosirirajweb3.png",['class' => 'img img-responsive', 'style'=>'width:80px;margin: 0 auto;']);
?>


<header class="main-header">
    <?= Html::a('<span class="logo-mini">'.$logo.'</span><span class="logo-lg"> <span style="    position: absolute;
    overflow: hidden;
    left: 27px;
    width: 49px;
    height: 50px;">'.$logo.'</span>' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php 
//                        echo '<li class="navbar-text">';
//                        echo \lajax\languagepicker\widgets\LanguagePicker::widget([
//                            'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
//                            'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
//                        ]);
//                        echo '</li>';
                ?>
                
                
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if (Yii::$app->user->identity->userProfile->image) : ?>
                            <img src="<?= Yii::$app->user->identity->userProfile->image ?>" class="user-image" alt>
                        <?php else: ?>
                            <img src="<?= Yii::$app->homeUrl . '/static/img/default.png' ?>" class="user-image" alt>
                        <?php endif ?>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <?php if (Yii::$app->user->identity->userProfile->image) : ?>
                                <img src="<?=  Yii::$app->user->identity->userProfile->image ?>" class="img-circle" alt>
                            <?php else: ?>
                                <img src="<?= Yii::$app->homeUrl . '/static/img/default.png' ?>" class="img-circle" alt>
                            <?php endif ?>
                            <p>
                                <?= Yii::$app->user->identity->username ?>
                                <small><?= Yii::t('backend', 'Member since {0, date}', Yii::$app->user->identity->created_at) ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(Yii::t('backend', 'Profile'), ['/user/profile'], ['class' => 'btn btn-default btn-flat']) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(Yii::t('backend', 'Logout'), ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-cogs"></i>', ['/site/settings']) ?>
                </li>
            </ul>
            
        </div>
    </nav>
</header>
