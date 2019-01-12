<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\models\NavItem;
use lo\modules\noty\Wrapper;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
janpan\jn\assets\JScrollbarAssets::register($this);
?>
<header class="main-header">
    <?php NavBar::begin([
        'brandLabel' =>"<div style='display: flex;flex-direction: row;'><div>".Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name, 'style'=>'    max-width: 100px;    margin-top: -10px;    width: 40px;    margin-right: 5px;'])."</div><div>LOGO</div></div>",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',            
        ],
        'innerContainerOptions' => ['class' => 'container-fluid'],
        
    ]);
    $menuItems = [
        ['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
        [
            'label' => Yii::t('frontend', 'Users'),
            'url' => ['/account/default/users'],
            'visible' => !Yii::$app->user->isGuest,
        ],
        ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('frontend', 'Login'), 'url' => ['/account/sign-in/login']];
    } else {
        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'url' => '#',
            'items' => [
                ['label' => Yii::t('frontend', 'Settings'), 'url' => ['/account/default/settings']],
                [
                    'label' => Yii::t('frontend', 'Backend'),
                    'url' => env('BACKEND_URL'),
                    'linkOptions' => ['target' => '_blank'],
                    'visible' => Yii::$app->user->can('administrator'),
                ],
                [
                    'label' => Yii::t('frontend', 'Logout'),
                    'url' => ['/account/sign-in/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                ],
            ],
        ];
    }
    echo Nav::widget([        
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => ArrayHelper::merge(NavItem::getMenuItems(), $menuItems),
    ]);
    NavBar::end() ?>
  </header>
