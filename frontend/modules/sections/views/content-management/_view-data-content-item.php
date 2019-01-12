<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
    
<a href="<?= Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}"?>" style="margin-top: 5px;" href=""   data-id="<?= $model['id']?>" id="<?= "btn-{$model['id']}"?>" data-action="view-file" class="content-popup btnCall text-left">
    <?php
        if($model['file_type'] == '2'){
            echo Html::img("{$model['file_path']}/thumbnail/{$model['file_name']}",
                    [
                        'class'=>'img img-responsive img-rounded',
                        'style'=>''
            ]);            
        }else if($model['file_type'] == '3'){
            echo "
                <video style='width:100%;height: 100px;' controls>
                    <source src='{$model['file_path']}/{$model['file_name']}' type='video/mp4'>                 
                    Your browser does not support the video tag.
                </video>
            ";         
        }else if($model['file_type'] == '4'){
            echo "            
                <audio controls style='width:100%;height: 100px;'>
                    <source src='{$model['file_path']}/{$model['file_name']}' type='audio/mpeg'>                 
                    Your browser does not support the video tag.
                </audio>
                ";
        }else if($model['file_type'] == '6'){
            echo Html::img("{$model['file_path']}/{$model['file_name']}", 
                [
                    'class'=>'img img-responsive img-rounded',
                    'style'=>'width:100px;height: 80px;'
                ]);
        }else{
            echo "<div class='text-center'><i class='fa fa-file-o' style='font-size:30pt;'></i></div>";
        }
        $name_str = backend\modules\sections\classes\JFiles::lengthName($model['file_name_org'] , 20);
        echo "<div title='{$model['file_name_org']}' >{$name_str}</div>";
    ?>
</a>


 
<?php $this->registerCss("a{color:#000;}")?> 
<?php 
    $modal = "modal-contents";
?>
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    
</script>
<?php \richardfan\widget\JSRegister::end();?>
