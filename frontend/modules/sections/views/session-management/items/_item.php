<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="<?= Url::to(['/sections/content-management/view?content_id='])?><?= $model['id']?>">
<div class="product-img">
    <img src="<?= $model['thumn_image'] ?>" alt="<?= Html::encode($model['name']) ?>">
</div>
<div class="product-info">
     <?= Html::encode($model['name']) ?>     
    <span class="product-description">
        
    </span>
</div>
</a>