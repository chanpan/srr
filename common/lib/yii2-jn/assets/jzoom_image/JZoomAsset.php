<?php
namespace janpan\jn\assets\jzoom_image; 
use yii\web\AssetBundle;
class JZoomAsset extends AssetBundle{
    public $sourcePath = '@janpan/jn/assets/jzoom_image';
	public $css = [
            //'css/style.css'
	];
	public $js = [
             'jquery.elevatezoom.js',
//            'js/bootstrap.min.js',
//            'js/popper.min.js',
//            'js/docsearch.min.js',
//            'js/docs.min.js'
	];
	public $depends = [
	     'yii\web\YiiAsset',
             'yii\bootstrap\BootstrapAsset',	 
	];
}
