<?php 
    use yii\helpers\Html;
    $link_url = yii\helpers\Url::to(['/sections/content-management/view-file?content_id='])."{$model->content_id}&file_id={$model->id}&filet_id={$model->file_type}";
    $meta_text = appxq\sdii\utils\SDUtility::string2Array($model['meta_text']);
    
    $content = \backend\modules\sections\classes\JContent::getContentById($model->content_id);
    $breadcrumb = \backend\modules\sections\classes\JSection::getBreadcrumb($content['section_id']);
    
    $breadcrumb[] = ['label' => $content['name'], 'url' => ['/sections/content-management/view?content_id='.$content['id']]];
    //$mb = round(($meta_text['size']/1024)/1024);
    $size = \appxq\sdii\utils\SDUtility::convertToReadableSize($meta_text['size']);
    $meta_file = "<div class='label label-default'>
                      <label>".Yii::t('file', 'Type')." : {$meta_text['type']}</label> &nbsp;&nbsp;
                      <label>".Yii::t('file', 'Size')." : {$size}</label>
                  </div>";
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $model->file_name_org?></h3>                 
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="">
        <?php echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]); ?>
        <?php if($model->file_type == "2"):?>
        <a href="<?= $link_url?>" target="_blank">
            <div class="media">
                <div class="media-left">
                  <?= Html::img("{$model['file_path']}/thumbnail/{$model['file_name']}", 
                            [
                                'class'=>'media-object',
                                'style'=>'width:60px'
                            ]);?>
                </div>
                <div class="media-body">
                  <h4 class="media-heading"><?= $model['file_name_org']?></h4>                  
                  <?= $meta_file?>
                </div>
                
            </div>
        </a>    
        <?php endif; ?>
        <?php if($model->file_type == "3"):?>
        <a href="<?= $link_url?>" target="_blank">
            <div class="media">
                <div class="media-left">
                    <video style='width:95px' class="media-object" controls>
                    <source src='<?php echo "{$model['file_path']}/{$model['file_name']}"; ?>' type='video/mp4'>                 
                        Your browser does not support the video tag.
                  </video>
                </div>
                <div class="media-body">
                  <h4 class="media-heading"><?= $model['file_name_org']?></h4>
                  <?= $meta_file?>
                </div>  
            </div>
        </a>    
        <?php endif; ?>
        
        <?php 
            if($model['file_type'] == '4'){
                echo "
                  <a href='{$link_url}' target='_blank'>
                        <div class='media'>
                            <div class='media-left'>
                                <audio style='width:95px' class='media-object' controls>
                                <source src='{$model['file_path']}/{$model['file_name']}' type='audio/mpeg'>                 
                                    Your browser does not support the video tag.
                                </source>    
                              </audio>
                            </div>
                            <div class='media-body'>
                              <h4 class='media-heading'>{$model['file_name_org']}</h4>
                              {$meta_file}
                            </div>  
                        </div>
                    </a>
                ";
            }else{
                echo "
                  <a href='{$link_url}' target='_blank'>
                        <div class='media'>
                            <div class='media-left'>
                                <i class='fa fa-file-o' style='font-size:20pt;'></i>
                            </div>
                            <div class='media-body'>
                              <h4 class='media-heading'>{$model['file_name_org']}</h4>
                              {$meta_file}
                            </div>  
                        </div>
                    </a>
                ";
            }
        ?>
    </div> 
</div>