<?php

namespace janpan\jn\assets\pdfjs;
use yii\web\AssetBundle;
class PdfJsAssets extends AssetBundle{
    public $sourcePath='@janpan/jn/assets/pdfjs';
    public $css = [       
        'style.css',
    ];
    public $js = [ 
        'pdf.js',
        'pdf.worker.js',
//        'compat.js'
         
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
