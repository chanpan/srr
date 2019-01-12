<?php

namespace janpan\jn\assets;

use yii\web\AssetBundle;

class Bootstrap4Assets extends AssetBundle {

	public $sourcePath = '@janpan/jn/assets/bootstrap4';
	public $css = [
//            'css/bootstrap.min.css',
//            'css/docsearch.min.css',
//            'font-awesome-4.7.0/css/font-awesome.min.css',
            'css/style.css'
	];
	public $js = [
//            'js/jquery-3.3.1.slim.min.js',
//            'js/bootstrap.min.js',
//            'js/popper.min.js',
//            'js/docsearch.min.js',
//            'js/docs.min.js'
	];
	public $depends = [
	    //'yii\web\YiiAsset',
            //'yii\bootstrap\BootstrapAsset',	 
	];

}
