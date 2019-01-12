<?php

use yii\helpers\Html;
use yii\helpers\Url;


\janpan\jn\assets\jlightbox\JLightBoxAsset::register($this);
\janpan\jn\assets\file_download\FileDownloadAsset::register($this);
?>
<div class="col-md-8 view-file-left">
    <div class="panel panel-default">
        <div class="panel-heading">
<?php //appxq\sdii\utils\VarDumper::dump($dataDefault); ?>
<?= $dataDefault['file_name_org'] ?>
        </div> 
        <div class="panel-body" style="overflow: hidden;">  
            <div class="row" style="margin-bottom:10px;text-align: center;" id="preview-file">
                <div class="col-md-12">
                <div style="background: #292929; padding: 5px; border: 1px solid #bdbdbd; border-radius: 5px;overflow: scroll;">
                        <?php if(Yii::$app->request->get('file_id') == ""): ?>
                        <h2 style="color:#fff;font-size:30pt;">
                                <?= Yii::t('section', 'Please Select File')?>
                            </h2>
                       <?php else:?>
                            <?php
                                if ($dataDefault['file_type'] == '2' || $dataDefault['file_type'] == '6') {
                                    $fileName = explode('.',$dataDefault['file_name']);
                                    $fileNameArr = ['jpeg', 'jpg', 'png','gif','tiff', 'tif'];
                                    if(in_array(end($fileName), $fileNameArr)){
                                        if ((!Yii::$app->user->isGuest) && (Yii::$app->user->can("administrator") || Yii::$app->user->can("manager"))) {
                                            //echo "<div class='label label-default pull-left'><a href='{$dataDefault['file_path']}/{$dataDefault['file_name']}' download>Download</a></div>";
                                                echo "<div class='label label-default pull-right'>2124 x 1414 Pixel</div>";
                                                echo "<div id='lightgallerys'>";
                                                echo Html::beginTag("div", ['class' => 'flex-3', 'data-src' => "{$dataDefault['file_path']}/{$dataDefault['file_name']}", 'data-sub-html' => "{$dataDefault['details']}"]);
                                                echo \yii\helpers\Html::img("{$dataDefault['file_path']}/{$dataDefault['file_name']}", [
                                                                            'class' => 'img img-responsive'
                                                                            ]);
                                                echo Html::endTag("div");
                                                echo "</div>";
                                            
                                            } else {
                                                
                                                echo "<div class='label label-default pull-right'>1024 x 768 Pixel</div>";
                                                echo "<div id=''>";
                                                echo Html::beginTag("div", ['class' => 'flex-3', 'data-src' => "{$dataDefault['file_path']}/thumbnail/{$dataDefault['file_name']}", 'data-sub-html' => "{$dataDefault['details']}"]);
                                                echo \yii\helpers\Html::img("{$dataDefault['file_path']}/thumbnail/{$dataDefault['file_name']}", [
                                                                            'class' => 'img img-responsive'
                                                                            ]);
                                                echo Html::endTag("div");
                                                echo "</div>";
                                            }
                                            $modelImage = $dataProvider->getModels();
                                            echo "<div id='lightgallery' style='height: 80px;
                                        overflow: hidden;
                                        display: flex;
                                            flex-direction: row;
                                            /* flex-basis: 54%; */
                                            flex-wrap: wrap;
                                        padding: 10px;'>";
                                            foreach($modelImage as $k=>$v){
                                                $fileNameLoop = explode('.',$v['file_name']);
                                                if(in_array(end($fileNameLoop), $fileNameArr)){
                                                    echo Html::beginTag("div", ['class' => '', 'data-src' => "{$v['file_path']}/{$v['file_name']}", 'data-sub-html' => ""]);
                                                    echo \yii\helpers\Html::img("{$v['file_path']}/{$v['file_name']}", [
                                                                                'class' => 'img img-responsive',
                                                                                'style'=>'width:80px;height:80px;    padding: 5px;'
                                                                                ]);
                                                    echo Html::endTag("div");
                                                }
                                                
                                                
                                            }
                                            echo "</div>";
                                    }else{
                                        echo "<h3 style='color:#fff; text-align:left;'>ไม่สามารถอ่านไฟล์ประเภท ".end($fileName)." ได้</h3>";
                                    }
                                    


                                    // echo yii\helpers\Html::img("{$dataDefault['file_path']}/{$dataDefault['file_name']}", ['class'=>'img img-responsive','style'=>"width:1024px;"]);
                                } elseif ($dataDefault['file_type'] == 3) {
                                    echo"
                                        <video style='width:100%' controls controlsList='nodownload'>
                                            <source src='{$dataDefault['file_path']}/{$dataDefault['file_name']}' type='video/mp4'>                 
                                            Your browser does not support the video tag.
                                        </video>
                                    ";
                                } elseif ($dataDefault['file_type'] == 4) {
                                    echo"
                                        <audio style='width:100%' controls controlsList='nodownload'>
                                            <source src='{$dataDefault['file_path']}/{$dataDefault['file_name']}' type='audio/mpeg'>                 
                                            Your browser does not support the audio tag.
                                        </audio>
                                    ";
                                } else {
                                    //echo "{$dataDefault['file_path']}/{$dataDefault['file_name']}";
                                    $api = \backend\modules\cores\classes\CoreOption::getParams("preview_doc", 'e');
                                    $file_type = ['ppt','pptx','doc','docx','xls','xlsx']; 
                                    $type = explode('.', $dataDefault['file_name']);
                                    
                                    $type = isset($type[1]) ? $type[1] : 'doc';
                                    
                                    if($type == 'docx' || $type== 'doc' || $type == 'odt'){
                                        if($type == 'docx'){
                                            $filenameStr = explode('.docx',$dataDefault['file_name']);
                                        }else if($type == 'doc'){
                                            $filenameStr = explode('.doc',$dataDefault['file_name']);
                                        }else{
                                            $filenameStr = explode('.odt',$dataDefault['file_name']);
                                        }
                                        
                                        echo '<embed src = "'.$dataDefault['file_path'].'/'.$filenameStr[0].'.pdf#toolbar=0&navpanes=0&scrollbar=0" width = "500" height = "500">';
                                        
                                    }else if($type == 'pdf'){
                                        
                                        echo '<embed src = "'.$dataDefault['file_path'].'/'.$dataDefault['file_name'].'#toolbar=0&navpanes=0&scrollbar=0" width = "500" height = "500">';
                                    }if($type == 'xlsx' || $type== 'xls'){
                                        if($type == 'xlsx'){
                                            $filenameStr = explode('.xlsx',$dataDefault['file_name']);
                                        }else{
                                            $filenameStr = explode('.xls',$dataDefault['file_name']);
                                        }
                                        echo '<embed src = "'.$dataDefault['file_path'].'/'.$filenameStr[0].'.pdf#toolbar=0&navpanes=0&scrollbar=0" width = "500" height = "500">';
                                        
                                    }if($type == 'pptx' || $type== 'ppt'){
                                        if($type == 'pptx'){
                                            $filenameStr = explode('.pptx',$dataDefault['file_name']);
                                        }else{
                                            $filenameStr = explode('.ppt',$dataDefault['file_name']);
                                        }
                                        echo '<embed src = "'.$dataDefault['file_path'].'/'.$filenameStr[0].'.pdf#toolbar=0&navpanes=0&scrollbar=0" width = "500" height = "500">';
                                        
                                    }
                                    if($type == 'odt'){
                                        $filenameStr = explode('.odt',$dataDefault['file_name']);
                                        echo '<embed src = "'.$dataDefault['file_path'].'/'.$filenameStr[0].'.pdf#toolbar=0&navpanes=0&scrollbar=0" width = "500" height = "500">';
                                        
                                    }else{
                                        
                                        $typeArr = ['txt', 'json','xml','html','xml','php','js','ts'];
                                        if(in_array($type, $typeArr)){
                                            try{
                                                $data=file("{$dataDefault['file_path']}/{$dataDefault['file_name']}");  // ข้อมูลที่ได้จากการใช้ Function file() จะได้ออกมาเป็น Array แต่ละบัีนทัดข้อมูลที่เก็บใน
                                                
                                                for($i=0;$i<count($data);$i++){  // วนรอบเพื่อแสดงผลขอ้มูล
                                                    
                                                    echo "<div style='color:#fff; text-align:left;'>".Html::encode($data[$i])."</div>";
                                                    
                                                }
                                            }catch(\Exception $e){
                                                echo "<h3 style='color:#fff; text-align:left;'>ไม่สามารถอ่านไฟล์ประเภท {$type} ได้</h3>";
                                            }
                                        }else{
                                           // echo "<h3 style='color:#fff; text-align:left;'>ไม่สามารถอ่านไฟล์ประเภท {$type} ได้</h3>";
                                        }
                                        
                                    }
                                    
                                    


                                }
                                ?>
                       <?php endif; ?>
                        
                        
                    </div>
                </div>
            </div> 
        </div>
    </div> 

    <div class="panel">
        <div class="panel-body">
            <?php
            echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'row',
                    'id' => 'file_types',
                ],
                'itemOptions' => function($model) {
                    return ['tag' => 'div', 'data-id' => $model['id'], 'class' => 'col-md-4 col-xs-6', 'style' => '    border: 1px solid #f3f3f3; margin-bottom:0px;'];
                },
                'layout' => "{pager}\n{items}\n",
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_item', ['model' => $model]);
                },
            ]);
            ?>
            <div class="clearfix"></div>
            <?php if (!Yii::$app->user->isGuest) { ?>

<?php } ?>
        </div>
    </div>
</div>


<?php richardfan\widget\JSRegister::begin(); ?>
<script>

    setTimeout(function () {
        $('#lightgallery').lightGallery();
    }, 1000);
     
    
    $('#btnDownload').on('click', function () {
        let checkboxValues = [];
        $('input[type="checkbox"]:checked').each(function (index, elem) {
          checkboxValues.push($(elem).attr('data-id'));
        });
        let id_str = checkboxValues.toString();
        if (!id_str) {
            let res = {message:'<?= Yii::t('section','Please select a file.')?>',status:'error'};
            <?= \appxq\sdii\helpers\SDNoty::show('res.message', 'res.status') ?>
            return false;
        }
        
        //return false;
                         
        checkboxValues.map(function(id){
             let url = '<?= Url::to(['/site/download-file'])?>';
             window.open(`${url}?id=${id}`, '_BLANK');
             //              console.log(url);
        });
        
        
        return false;
    });
    
    $('#btnCart').on('click', function () {
        let checkboxValues = [];
        $('input[type="checkbox"]:checked').each(function (index, elem) {
            checkboxValues.push($(elem).attr('data-id'));
        });
        let id_str = checkboxValues.toString();
        if (!id_str) {
            let res = {message:'<?= Yii::t('section','Please select a file.')?>',status:'error'};
            <?= \appxq\sdii\helpers\SDNoty::show('res.message', 'res.status') ?>
            return false;
        }
        let url = "<?= Url::to(['/sections/cart/add-cart'])?>";
        let size = $('.check-size:checked').val();
        $.post(url, {id: id_str, size: size}, function (res) {
            if (res['status'] == 'success') {
                $('#globalCart').html(res['data']['count']);
<?= \appxq\sdii\helpers\SDNoty::show('res.message', 'res.status') ?>
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }

        });
        return false;
    });

    $('input[name="selectAll"]').change(function () {
        let id = $(this).attr('data-id');
        if ($(this).is(":checked")) {

            $('#label-' + id).css({background: '#3867d6', color: '#fff', padding: '5px'});
            $('.checkbox').each(function () { //loop through each checkbox
                $(this).attr('checked', true); //check 
            });
        } else {
            //console.log('uncheck');
            $('.checkbox').each(function () { //loop through each checkbox
                $(this).attr('checked', false); //uncheck              
            });

            $('#label-' + id).css({background: 'transparent', color: '#000', padding: '5px'});
        }
        //$('#textbox1').val($(this).is(':checked'));        
    });








 function disableselect(e){
return false
}

function reEnable(){
return true
}

//if IE4+
document.onselectstart=new Function ("return false")

//if NS6
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}

var message="Function Disabled!";
///////////////////////////////////
function clickIE() {if (document.all) {alert(message);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

document.oncontextmenu=new Function("return false");
document.addEventListener("keydown", onKeyDown, false);

function onKeyDown(e) {
 var x = e.keyCode;
 if(x==123){
  console.log('Your pressed Fn+F7');
  return false;
 }
}

 

</script>
<?php richardfan\widget\JSRegister::end(); ?>

<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    #myFrame {
        
    }
    #iframe div#WordViewerStatusBar {
        display: none;
    }

    /* Hide the browser's default checkbox */
    .container input[type='checkbox'] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 5px;
        left: 36px;
        height: 25px;
        width: 25px;
        background-color: #fff;
        border: 1px solid #88888c;
        border-radius: 5px;
        cursor: pointer;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #fff;
        border: 1px solid #4e1228;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color: #d2ab66;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 10px;
        top: 3px;
        width: 6px;
        height: 15px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .view-file-left,.view-file-right{margin-top:5px;}
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>
