 
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper; 
$url = "/sections/session-management?id={$model['id']}";
$name_str = backend\modules\sections\classes\JFiles::lengthName($model['name'], 18);
?>
 
<a href="<?= $url?>" class="media" style="position: relative;" title="<?= $model['name']?>">
    <div class="media-left"> 
      <?php // backend\modules\ezforms2\classes\EzfUiFunc::getEzformIcon($model, 42)?>
    </div>
    <div class="media-body"> 
        
        <p class="list-group-item-text"> 
        <div class="">
            <i class="fa <?= $model['icon']?>" style="font-size: 20pt; margin-right: 10px;"> </i> <?= Html::encode($name_str) ?> </div>
        </p>
        
    </div>
</a>
 