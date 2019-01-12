<?php

namespace janpan\jn\assets\croppie;
use yii\web\AssetBundle;
class JCroppieAssets extends AssetBundle{
    public $sourcePath='@janpan/jn/assets/croppie';
    public $css = [
        'croppie.css',
        'style.css',
    ];
    public $js = [ 
        'croppie.min.js'
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
