<?php

 
namespace janpan\jn\assets\slidetop;
 
class SlideTopAssets extends \yii\web\AssetBundle{
    public $sourcePath='@janpan/jn/assets/slidetop/assets';
    public $css = [ 
        'magnific-popup.css',
        'dist/ekko-lightbox.css'
    ];
    public $js = [
        //'index.js',
        'jquery.carousel.js', 
        'dist/ekko-lightbox.min.js'
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
