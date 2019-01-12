<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace janpan\jn\assets;

use yii\web\AssetBundle;

class ListdataAsset extends AssetBundle
{
    public $sourcePath='@janpan/jn/assets';

    public $css = [
        'css/style.css',
    ];
    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
