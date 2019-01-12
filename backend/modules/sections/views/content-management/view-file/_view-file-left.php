<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
    \janpan\jn\assets\ListdataAsset::register($this);
    \janpan\jn\assets\EzfToolAsset::register($this);
    \janpan\jn\assets\jlightbox\JLightBoxAsset::register($this);
//    \appxq\sdii\utils\VarDumper::dump($dataProvider);
   $fileType = Yii::$app->request->get('filet_id', '');
?>
<div class="col-md-8 view-file-left">
    <div class="box box-primary">
        <div class="box-header">
            <span class="pull-right">
                            <?php
                                echo Html::button("<i class='fa fa-plus'></i>", [
                                    'data-id' => $dataDefault['file_type'],
                                    'data-parent_id' => Yii::$app->request->get('id', '0'),
                                    'file_type'=>Yii::$app->request->get('filet_id', '0'),
                                    'data-action' => 'create',
                                    'class' => 'btn btn-success btnCreateFile',
                                    'title' => Yii::t('appmenu', 'Create'),
                                    'data-url' => Url::to(['/sections/session-management/create'])
                                ]);
                            ?> 
                         <?php
                                echo yii\helpers\Html::button("<i class='fa fa-trash'></i>", [                                     
                                    'data-parent_id' => Yii::$app->request->get('id', '0'),
                                    'file_type'=>Yii::$app->request->get('filet_id', '0'),
                                    'data-action' => 'create',
                                    'class' => 'btn btn-danger btnDeleteBySelect',
                                    'title' => Yii::t('appmenu', 'Delete'),
                                    'data-url' => Url::to(['/sections/session-management/create']), 
                                ]);
                            ?> 
            </span>
            <h2><?= $dataDefault['file_name_org'] ?></h2>
        </div> 
        <div class="box-body">
            
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-12">
                    <?php 
                        if($dataDefault['file_type'] == '2'){
                            echo "<div class='label label-default pull-right'>2124 x 1414 Pixel</div>";
                                echo "<div id='lightgallery'>";
                                echo Html::beginTag("div", ['class' => 'flex-3', 'data-src' => "{$dataDefault['file_path']}/{$dataDefault['file_name']}", 'data-sub-html' => "{$dataDefault['description']}"]);
                                echo \yii\helpers\Html::img("{$dataDefault['file_path']}/{$dataDefault['file_name']}", [
                                    'class' => 'img img-responsive'
                                ]);
                                echo Html::endTag("div");
                                echo "</div>";
                           // echo yii\helpers\Html::img("{$dataDefault['file_path']}/{$dataDefault['file_name']}", ['class'=>'img img-responsive','style'=>"width:1024px;"]);
                        }elseif ($dataDefault['file_type'] == 3) {
                            echo"
                                <video style='width:100%' controls>
                                    <source src='{$dataDefault['file_path']}/{$dataDefault['file_name']}' type='video/mp4'>                 
                                    Your browser does not support the video tag.
                                </video>
                            ";
                        }elseif ($dataDefault['file_type'] == 4) {
                            echo"
                                <audio style='width:100%' controls>
                                    <source src='{$dataDefault['file_path']}/{$dataDefault['file_name']}' type='audio/mpeg'>                 
                                    Your browser does not support the audio tag.
                                </audio>
                            ";
                        }
                    ?>
 
                </div>
            </div>
            <?=
            \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'col-md-12',
                    'id' => 'ezf_dad',
                ],
                'itemOptions' => function($model) {
                    return ['tag' => 'div','id'=>"img-{$model['id']}", 'data-id' => $model['id'], 'class' => 'dads-children col-md-3 col-sm-4 col-xs-6','style'=>'height: 200px;'];
                },
                'layout' => "{pager}\n{items}\n",
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_item', ['model' => $model]);
                },
            ]);
            ?>
            <div class="clearfix"></div>
            
        </div>
    </div>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
     
    .view-file-left{
        border-right: 1px solid #ecf0f5;
    } 
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>

<?php 
    $modal = "modal-contents";
?> 
    
    <?php \richardfan\widget\JSRegister::begin();?>
    <script>
           setTimeout(function () {
                $('#lightgallery').lightGallery();
            }, 1000);
            $('.btnCreateFile').on('click', function(){
                let id = $(this).attr('data-id');
                let content_id = '<?= Yii::$app->request->get('content_id', '')?>';
                $('#<?= $modal?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
                $('#<?= $modal?>').modal('show');
                let url = '<?= Url::to(['/sections/file-management/upload-file'])?>';
                let file_type = $(this).attr('file_type');
                $.get(url,{id:id,file_type:file_type,content_id:content_id}, function(res){
                    $('#<?= $modal?> .modal-content').html(res);
                });
               return false;
            });  
            $('.btnDeleteBySelect').click(function () { 
                     
                    let url = '<?= Url::to(['/sections/file-management/delete-file'])?>';
                    $(':checkbox:checked').each(function () {
                        let dataID = $(this).val();                         
                        if(!dataID){
                            return;
                        }
                        if(dataID != "on"){
                             $.post(url, {id:dataID}, function(result){                    
                                <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
                                $('#img-'+dataID).remove();    
                             });
                        }
                    }); 
               return false; 
            });
            $('#ezf_dad').dad({
                draggable:'.draggable',
                callback:function(e){
                    var positionArray = [];
                    $('#ezf_dad').find('.dads-children').each(function(){
                        positionArray.push($(this).attr('data-id'));
                    });

                    $.post('<?= \yii\helpers\Url::to(['/sections/session-management/forder-files']) ?>',{data:positionArray.toString(), type_id:'<?= $fileType?>'},function(result){
                        console.log(result);
                        return false;
                    });
                }
            });
            
    </script>
<?php \richardfan\widget\JSRegister::end();?>  