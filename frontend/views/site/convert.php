<?php 
    \janpan\jn\assets\file_download\FileDownloadAsset::register($this);
    //appxq\sdii\utils\VarDumper::dump($src);
?>

<img src="<?= $src?>"/>

<?php    richardfan\widget\JSRegister::begin();?>
<script> 
   download("<?= $src?>", "image.jpg", "image/jpg");
</script>
<?php    richardfan\widget\JSRegister::end();?>