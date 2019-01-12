<?php

namespace frontend\themes\siriraj2\assets;

use yii\web\AssetBundle;
class Siriraj2Assets extends AssetBundle{
    public $sourcePath = '@frontend/themes/siriraj2/assets';
    public $css = [
        'css/jquery-ui.min.css',
        'slick/slick.css',
        'slick/slick-theme.css',
        'css/style.css',
        'font_awesome/css/font-awesome.min.css',
        'css/fonts/stylesheet.css'
        
        //'css/ionicons.min.css',
         
    ];

    public $js = [ 
        //'js/jquery-ui.min.js',
        'slick/slick.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset', 
        'yii\jui\JuiAsset'
    ];
}
