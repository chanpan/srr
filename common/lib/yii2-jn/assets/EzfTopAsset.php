<?php

/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace janpan\jn\assets;

use yii\web\AssetBundle;

class EzfTopAsset extends AssetBundle {

    public $sourcePath='@janpan/jn/assets';
    
    public $css = [
    ];
    
    public $js = [
	'js/jquery.cookie.js',
        
    ];
    
    public $jsOptions = [
	'position' => \yii\web\View::POS_HEAD
    ];
    
    public $depends = [
	'yii\web\YiiAsset'
    ];

}
