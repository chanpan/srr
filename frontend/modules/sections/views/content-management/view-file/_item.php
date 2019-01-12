<?php

use yii\helpers\Html;
use yii\helpers\Url;

\janpan\jn\assets\file_download\FileDownloadAsset::register($this);
/*
  Yii::$app->user->can("administrator");
  Yii::$app->user->can("admin");
  Yii::$app->user->can("user");
 */
?> 
<?php $this->registerCss("a{color:#000;}") ?>


<a href="<?= Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}" ?>" style="margin-top: 5px;" href=""   data-id="<?= $model['id'] ?>" id="<?= "btn-{$model['id']}" ?>" data-action="view-file" class="content-popup btnCall text-left">
    <?php
    if ($model['file_type'] == '2' ||  $model['file_type'] == 6 ) {
        if ((!Yii::$app->user->isGuest) && (Yii::$app->user->can("administrator") || Yii::$app->user->can("manager") || Yii::$app->user->can("users"))) {
            echo "
                    <div class='row'>
                        <div class='col-md-6 col-xs-6 col-sm-6'>
                            <label class='container' >
                                <input type='checkbox'  class='checkbox' name='check_str' data-id={$model['id']}>
                                <span class='checkmark' style='margin-top: -5px;'></span>
                            </label>
                        </div>
                        <div class='col-md-6 col-xs-6 col-sm-6' style='padding-top:0px;'>
                            <a title='Download' class='btn btn-sm btn-primary download pull-right' data-type='{$model['file_type']}' data-id='{$model['id']}' data-name='{$model['file_name_org']}' href='#'><i class='fa fa-download'></i></a>
                        </div>
                    </div>
                    <div class='clearfix' style='    margin-bottom: 20px;'></div>
                ";
        }
        echo "<a style='text-align:center;display: block;' href='".Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}' style='margin-top: 5px;' href='#'  data-id='{$model['id']}' id='btn-{$model['id']}' data-action='view-file' class='content-popup btnCall text-left'>";
        
        $type = explode('_mark', $model['file_name']);
        $type = end($type);
        //\appxq\sdii\utils\VarDumper::dump($model['file_name']);
        if($type == '.gif'){
            $filename = explode('_preview', $model['file_view']);
            //\appxq\sdii\utils\VarDumper::dump($model['file_path']);
            $image = "{$model['file_path']}/thumbnail/{$filename[0]}_preview.gif";
           
            echo Html::img("{$image}",['class'=>'primary-img img img-responsive img-thumbnail','alt'=>"{$model['file_name_org']}", 'style' => 'height:120px;    margin: 0 auto;']);
        }else{
            $fileNameArr = ['jpeg', 'jpg', 'png','gif','tiff', 'tif'];
            $fileName = explode('.',$model['name']);
            $fileNameStr = end($fileName);
            
                if($model['file_type'] == '2'){
                    echo Html::img("{$model['file_path']}/thumbnail/{$model['file_view']}", [
                                   'class' => 'img img-responsive img-rounded',
                                   'style' => 'height:120px;    margin: 0 auto;'
                                   ]);
                }else{
                    if(in_array($fileNameStr, $fileNameArr)){
                        echo Html::img("{$model['file_path']}/{$model['name']}", [
                                       'class' => 'img img-responsive img-rounded',
                                       'style' => 'height:120px;    margin: 0 auto;'
                                       ]);
                    }else{
                        //echo "<i class='fa fa-file-archive-o'></i>";
                        echo "<div style='font-size: 56pt;text-align: center;padding-top: 15px;'><i class='fa fa-file-archive-o'></i></div>";
                    }
                    
                }
            
            //echo Html::img("{$image}",['class'=>'primary-img img img-responsive img-thumbnail','alt'=>"{$model['file_name_org']}"]);
            
        }
        
        
        echo "</a>";
    } else if ($model['file_type'] == '3') {
        if ((!Yii::$app->user->isGuest) && (Yii::$app->user->can("administrator") || Yii::$app->user->can("manager"))) {
            //echo Html::checkbox('checked', '', ['data-id'=>$model['id'] , 'class'=>'checkbox', 'name'=>"check[]"]); 
            echo "
                    <div class='row'>
                        <div class='col-md-6 col-xs-6 col-sm-6'>
                            <label class='container' >
                                <input type='checkbox'  class='checkbox' name='check_str' data-id={$model['id']}>
                                <span class='checkmark'></span>
                            </label>
                        </div>
                        <div class='' style='padding-top:5px;padding-top: 13px;
                                            position: absolute;
                                            right: 33px;'>
                            <a title='Download' class='btn btn-sm btn-primary download pull-right' data-type='{$model['file_type']}' data-id='{$model['id']}' data-name='{$model['file_name_org']}' href='#'><i class='fa fa-download' style='font-size: 12pt;'></i></a>
                        </div>
                    </div>
                    <div class='clearfix'></div>
                ";
        }
        echo "<a href='".Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}' style='margin-top: 5px;' href='#'  data-id='{$model['id']}' id='btn-{$model['id']}' data-action='view-file' class='content-popup btnCall text-left'>";
            echo "<div style='    margin: 0 auto; margin-top: 15px;'>";
            $storageUrl = \Yii::getAlias('@storageUrl');
            $folder = explode('/', $model['dir_path']);
        $folder = end($folder);
        $imgs = "{$storageUrl}/files/{$folder}/{$model['file_thumbnail']}";
        
            echo Html::img($imgs,['class'=>'img img-responsive' , 'style'=>'margin:0 auto;']);
            echo "</div>";
            echo "</a>";
    } else if ($model['file_type'] == '4') {
        if ((!Yii::$app->user->isGuest) && (Yii::$app->user->can("administrator") || Yii::$app->user->can("manager"))) {
            //echo Html::checkbox('checked', '', ['data-id'=>$model['id'] , 'class'=>'checkbox', 'name'=>"check[]"]); 
            echo "
                    <div class='row'>
                        <div class='col-md-6 col-xs-6 col-sm-6'>
                            <label class='container' >
                                <input type='checkbox'  class='checkbox' name='check_str' data-id={$model['id']}>
                                <span class='checkmark'></span>
                            </label>
                        </div>
                        <div class='col-md-6 col-xs-6 col-sm-6' style='padding-top:5px;'>
                            <a title='Download' class='btn btn-sm btn-primary download pull-right' data-type='{$model['file_type']}' data-id='{$model['id']}' data-name='{$model['file_name_org']}' href='#'><i class='fa fa-download'></i></a>
                        </div>
                    </div>
                    <div class='clearfix'></div>
                ";
        }
        echo "<a href='".Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}' style='margin-top: 5px;' href='#'  data-id='{$model['id']}' id='btn-{$model['id']}' data-action='view-file' class='content-popup btnCall text-left'>";
        echo "            
                <div style='font-size: 50pt;text-align: center;padding-top: 15px;'><i class='fa fa-music'></i></div>
            ";
        echo "</a>";
    } else if ($model['file_type'] == 5 || $model['file_type'] == 6 || $model['file_type'] == 7) {
            if ((!Yii::$app->user->isGuest) && (Yii::$app->user->can("administrator") || Yii::$app->user->can("manager") || Yii::$app->user->can("users"))) {

                echo "
                                <div class='row'>
                                    <div class='col-md-6 col-xs-6 col-sm-6'>
                                        <label class='container' >
                                            <input type='checkbox'  class='checkbox' name='check_str' data-id={$model['id']}>
                                            <span class='checkmark'></span>
                                        </label>
                                    </div>
                                    <div class='col-md-6 col-xs-6 col-sm-6' style='padding-top:5px;'>
                                        <a title='Download' class='btn btn-sm btn-primary download pull-right' data-type='{$model['file_type']}' data-id='{$model['id']}' data-name='{$model['file_name_org']}' href='#'><i class='fa fa-download'></i></a>
                                    </div>
                                </div>
                                <div class='clearfix'></div>
                            ";
            }       
            $fileNameStr = explode(".", $model['file_name']);
            ///appxq\sdii\utils\VarDumper::dump($fileNameStr);
            $icon = "";
            echo "<a href='".Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}' style='margin-top: 5px;' href='#'  data-id='{$model['id']}' id='btn-{$model['id']}' data-action='view-file' class='content-popup btnCall text-left'>";                        
            if ($fileNameStr[1] == 'doc' || $fileNameStr[1] == 'docx' || $fileNameStr[1] == 'odt') {
                $icon = "<i class='fa fa-file-word-o'></i>";
            } else if ($fileNameStr[1] == 'ppt' || $fileNameStr[1] == 'pptx') {
                $icon = "<i class='fa fa-file-powerpoint-o'></i>";
            } else if ($fileNameStr[1] == 'xls' || $fileNameStr[1] == 'xlsx') {
                $icon = "<i class='fa fa-file-excel-o'></i>";
            } else if ($fileNameStr[1] == 'pdf') {
                $icon = "<i class='fa fa-file-pdf-o'></i>";
            } else if ($fileNameStr[1] == 'zip' || $fileNameStr[1] == 'rar') {
                $icon = "<i class='fa fa-file-pdf-o'></i>";
            } else if($fileNameStr[1] == 'html' || $fileNameStr[1] == 'xml'){
                $icon = "<i class='fa fa-html5'></i>";
            }
            else if($fileNameStr[1] == 'txt'){
                $icon = "<i class='fa fa-file-text'></i>";
            }else if($fileNameStr[1] == 'json' || $fileNameStr[1] == 'php' || $fileNameStr[1] == 'js' || $fileNameStr[1] == 'ts'){
                $icon = "<i class='fa fa-code'></i>";
            }else if($fileNameStr[1] == 'css'){
                $icon = "<i class='fa fa-css3'></i>";
            }
            else {
                $icon = "<i class='fa fa-file-archive-o'></i>";
            }
                //echo $icon;
                
                echo "<div style='font-size: 80pt;text-align: center;padding-top: 15px;'>{$icon}</div>";
            echo "</a>";
         
//        echo "<a href='/sections/content-management/view-file?content_id={$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}' style='margin-top: 5px;' href='#'  data-id='{$model['id']}' id='btn-{$model['id']}' data-action='view-file' class='content-popup btnCall text-left'>";
//        
//        echo "</a>";
    } 
//    else {
//        if ((!Yii::$app->user->isGuest) && (Yii::$app->user->can("administrator") || Yii::$app->user->can("admin") || Yii::$app->user->can("users"))) {
//            echo "
//                    <div class='row'>
//                        <div class='col-md-6 col-xs-6 col-sm-6'>
//                            <label class='container' >
//                                <input type='checkbox'  class='checkbox' name='check_str' data-id={$model['id']}>
//                                <span class='checkmark'></span>
//                            </label>
//                        </div>
//                        <div class='col-md-6 col-xs-6 col-sm-6' style='padding-top:5px;'>
//                            <a title='Download' class='btn btn-sm btn-primary download pull-right' data-type='{$model['file_type']}' data-id='{$model['id']}' data-name='{$model['file_name_org']}' href='{$model['file_path']}/{$model['file_name']}'><i class='fa fa-download'></i></a>
//                        </div>
//                    </div>
//                    <div class='clearfix'></div>
//                ";
//        }
//        echo "<a href='/sections/content-management/view-file?content_id={$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}' style='margin-top: 5px;' href='#'  data-id='{$model['id']}' id='btn-{$model['id']}' data-action='view-file' class='content-popup btnCall text-left'>";
//        echo "<div class='text-center'><i class='fa fa-file-o' style='font-size:30pt;'></i></div>";
//    } echo "</a>";
    $name_str = backend\modules\sections\classes\JFiles::lengthName($model['file_name_org']);
    echo "<div style='padding: 5px;text-align: center;padding-bottom:10px;' title='{$model['file_name_org']}'>{$name_str}</div>";
    ?>
</a>
<!--<div id="show-img">xxx</div>-->

    <?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('.download').on('click', function () {
        let url = '<?= Url::to(['/site/download-file'])?>';//$(this).attr('data-href');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        let type = $(this).attr('data-type');
        //location.href = `${url}?id=${id}&type=${type}&name=${name}`;
        window.open(`${url}?id=${id}&type=${type}&name=${name}`, '_BLANK');
//        $.get(url, {id:id, name:name, type:type}, function(data){
//            location.
//        });
         
        //download("data:image/gif;base64,R0lGODlhRgAVAIcAAOfn5+/v7/f39////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////yH5BAAAAP8ALAAAAABGABUAAAj/AAEIHAgggMGDCAkSRMgwgEKBDRM+LBjRoEKDAjJq1GhxIMaNGzt6DAAypMORJTmeLKhxgMuXKiGSzPgSZsaVMwXUdBmTYsudKjHuBCoAIc2hMBnqRMqz6MGjTJ0KZcrz5EyqA276xJrVKlSkWqdGLQpxKVWyW8+iJcl1LVu1XttafTs2Lla3ZqNavAo37dm9X4eGFQtWKt+6T+8aDkxUqWKjeQUvfvw0MtHJcCtTJiwZsmLMiD9uplvY82jLNW9qzsy58WrWpDu/Lp0YNmPXrVMvRm3T6GneSX3bBt5VeOjDemfLFv1XOW7kncvKdZi7t/S7e2M3LkscLcvH3LF7HwSuVeZtjuPPe2d+GefPrD1RpnS6MGdJkebn4/+oMSAAOw==", "dlDataUrlBin.gif", "image/gif");
//        if (type == '5') { 
//             url = '<?= Url::to(['/site/get-url-file'])?>';
//             $.get(url, {id: id}, function (data) {
//               if(data['status'] === "success"){
//                   downloadFile(data['data']['path'], data['data']['name']);
//               }
//                 
//            });
//        } else {
//            $.get(url, {id: id}, function (data) {
//                console.log(name);
//                download(data, name);
//            });
//        }

        return false;
    });

    function downloadFile(url, name) {

        var a = document.createElement("a");
        a.style.display = "none";
        a.href = url;
        a.download = name;
        a.click();
    }
</script>
<?php richardfan\widget\JSRegister::end(); ?>
