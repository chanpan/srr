<?php
    use yii\helpers\Html;
    $section_obj = \common\models\Sections::findOne($data_id);   
     
?>
<?php if(!isset($_GET['id'])):?>
    <div>

        <?php echo $this->render('_searchbar');?>  
    </div>
    <div class="clearfix" style="margin-bottom:10px;"></div>
<?php else:?>
    <div class="row" style="margin-bottom: 10px;margin-top: 5px;">                     
        <div class="col-md-12">
            <?= $this->render('_searchbar'); ?>
        </div>
    </div>    
<?php endif; ?> 
<div class="col-md-12 section-right"> 
    
    <?php if($public == '1'): ?>
    <div class="panel panel-default">
            <?php if (isset($_GET['id'])): ?>
                <div class="panel-heading">   
                    <?= "<i class='fa {$section_obj['icon']}'></i> {$section_obj['name']}" ?>
                </div>            
            <?php else: ?>

            <?php endif; ?>                   
        
        <div class="panel-body">            
            <div class="content-data" style="display: flex;flex-direction: column;margin-top:20px;margin-bottom:50px;">                    
                <div style="margin-bottom: -25px;font-size: 12px;">                   
                    
                </div>
                
                <?php if(isset($_GET['id'])):?>
                    <div class="clearfix" style="margin-bottom:30px;"></div>
                <?php else:?>
                    <div class="clearfix" style="margin-bottom:10px;"></div>
                <?php endif; ?>
                <div id="content-html">                    
                    <?= $content_section->content; ?>
                </div> 
            </div>             
        </div>
    </div>
    <?php endif; ?>
     
    <div class="clearfix"></div>
    <div>
         <?php
//         appxq\sdii\utils\VarDumper::dump($contentProvider);
            echo $this->render('right-content-dynamic',[
                'contentProvider'=>$contentProvider, 
                'data_id'=> $data_id, 
                'parent_id'=>$content_section['id'],
                'public'=>$public,
                'content_section'=>$content_section 
               ]    
        );?>    
    </div>

    
    
    <div class="clearfix"></div>
    <?php
//                 \yii\widgets\ListView::widget([
//                    'dataProvider' => $contentProvider,
//                    'options' => [
//                        'tag' => 'ul',
//                        'class' => 'products-list product-list-in-box',
//                        'id' => 'section-all',
//                        'style'=>'padding: 2px;'
//                    ],
//                    'itemOptions' => function($model) {
//                        return ['tag' => 'li', 'data-id' => $model['id'], 'class' => 'item'];
//                    },
//                    'layout' => "{items}\n{pager}",
//                    'itemView' => function ($model, $key, $index, $widget) {
//                        return $this->render('_right_content_item', ['model' => $model]);
//                    },
//                ]);
            ?>
<!--    <div class="box box-primary">
        
        <div class="box-body">
            
            
        </div>
    </div>-->

</div>