<?php

namespace janpan\jn\assets;

use yii\web\AssetBundle;

class JMegaMenuAssets extends AssetBundle {

	public $sourcePath = '@janpan/jn/assets/megamenu';
	public $css = [
            'css/webslidemenu.css',
            'font-awesome-4.7.0/css/font-awesome.min.css',
            'css/demo.css',
            'css/style.css'
	];
	public $js = [
            'js/webslidemenu.js'
	];
	public $depends = [
	    'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',	 
	];

}
