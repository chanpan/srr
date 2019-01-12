<?php

namespace janpan\jn\assets\jqueryui;

use yii\web\AssetBundle;

class JQueryUiAssets extends AssetBundle {

	public $sourcePath = '@janpan/jn/assets/jqueryui';
	public $css = [
//            'css/bootstrap.min.css',
//            'css/docsearch.min.css',
//            'font-awesome-4.7.0/css/font-awesome.min.css',
            'jquery-ui.css',
            'jquery-ui.theme.css'
	];
	public $js = [
//            'js/jquery-3.3.1.slim.min.js',
//            'js/bootstrap.min.js',
//            'js/popper.min.js',
//            'js/docsearch.min.js',
            'jquery-ui.min.js'
	];
	public $depends = [
	    //'yii\web\YiiAsset',
            //'yii\bootstrap\BootstrapAsset',	 
	];

}
