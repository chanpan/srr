
<?php 
     $images = \backend\modules\sections\classes\JContent::getImageMost();
     //\appxq\sdii\utils\VarDumper::dump($images);
?>
<?php if(!$images):?>
<h2 class="alert alert-info"><?= Yii::t('section','Not fount data')?></h2>
<?php endif; ?>
<section class="multiple-items">
    <?php foreach($images as $k=>$i): ?>
    <?php 
    
        $detail = backend\modules\sections\classes\JFiles::lengthName($i['details'], 60);
        $fileName = backend\modules\sections\classes\JFiles::lengthName($i['file_name_org'], 60);
        if($k == 9){
            continue;
        }
   ?>
    <a data-id='<?= $i['id']?>' title='<?= $i['details']?>' target="_BLANK" href="<?= yii\helpers\Url::to(['/sections/content-management/view-file?content_id='])?><?= $i['content_id'] ?>&file_id=<?= $i['id'] ?>&filet_id=<?= $i['file_type'] ?>">    
            <img class="img img-responsive img-rounded image-sliders" src="<?= "{$i['file_path']}/thumbnail/{$i['file_view']}"?>">
            <div class="text-center captur-text"><?= $fileName?></div>
            
        </a>
    <?php endforeach; ?>
</section> 
<?php richardfan\widget\JSRegister::begin(); ?>
<script>
       $('.multiple-items').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
    
</script>
<?php richardfan\widget\JSRegister::end(); ?>
