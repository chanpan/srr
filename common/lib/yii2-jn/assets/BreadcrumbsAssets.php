<?php

namespace janpan\jn\assets;

use yii\web\AssetBundle;

class BreadcrumbsAssets extends AssetBundle {

	public $sourcePath = '@janpan/jn/assets/breadcrumbs';
	public $css = [
            'css/reset.css',
            'css/style.css'
	];
	public $js = [
            'js/modernizr.js'
	];
	public $depends = [
	    //'yii\web\YiiAsset',
            //'yii\bootstrap\BootstrapAsset',	 
	];

}
