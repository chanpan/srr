<?php 
    use yii\helpers\Html;
    $folderImage = Yii::getAlias('@storageUrl/avatars/folder.png');
?>
 
<div class="product-img">
    <?= \yii\helpers\Html::img($model['thumn_image'], ['class'=>'img img-responsive'])?>
</div>
<div class="product-info">
    <a href="<?= yii\helpers\Url::to(['/sections/content-management/view?content_id='])?><?= $model['id']?>" class="product-title"><?= $model['name'] ?>
        <span class="label label-warning pull-right"><?= \appxq\sdii\utils\SDdate::mysql2phpDate($model['create_date']) ?>  </span></a>
    <span class="product-description">
        <?= $model['description'] ?>
    </span>
</div>


