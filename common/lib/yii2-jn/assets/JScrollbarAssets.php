<?php

namespace janpan\jn\assets;

use yii\web\AssetBundle;

class JScrollbarAssets extends AssetBundle {

	public $sourcePath = '@janpan/jn/assets/jscrollbar';
	public $css = [
            'jquery.scrollbar.css',
            'style.css'
	];
	public $js = [
            'jquery.scrollbar.js'
	];
	public $depends = [
	    'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',	 
	];

}
