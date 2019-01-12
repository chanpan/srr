<?php

namespace janpan\jn\assets\date_picker;

use yii\web\AssetBundle;

class JFlatpickrAssets extends AssetBundle {

	public $sourcePath = '@janpan/jn/assets/date_picker';
	public $css = [
             
	];
	public $js = [
            'th.js'
	];
	public $depends = [
	    'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',	 
	];

}
