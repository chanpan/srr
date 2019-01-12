<?php
    use yii\helpers\Html;
    $section_obj = \common\models\Sections::findOne($data_id);   
    //appxq\sdii\utils\VarDumper::dump($section_obj);
?>
<div class="col-md-9 section-right">
    
    <?php if($public == '2'): ?>
        <div class="box box-primary">
        <div class="box-header">
            <h4><?= "<i class='fa {$section_obj['icon']}'></i> {$section_obj['name']}"?></h4>
            <?php if(isset($_GET['id'])):?>
                <div class="row">                     
                    <?= $this->render('_searchbar');?>
                </div>
            <?php endif; ?>
        </div>
        <div class="box-body">            
            <div class="content-data" style="display: flex;flex-direction: column;margin-top:20px;margin-bottom:50px;">                    
                <div style="margin-bottom: -25px;">
                    <div class="pull-left">
                        <div>
                            <dl class="dl-horizontal">
                                <dt><i class="fa fa-calendar"> วันที่สร้าง:</i></dt>
                                <dd><?= appxq\sdii\utils\SDdate::mysql2phpDate($section_obj['create_date'])?></dd>
                                <dt><i class="fa fa-user"> โดย:</i></dt>
                                <dd><?= common\modules\cores\User::getProfileNameByUserId($section_obj['create_by'])?></dd>
                            </dl>
                              
                        </div>                        
                    </div>
                    <div class="pull-right">
                        <?php                                     
                            echo Html::button("<i class='fa fa-pencil'></i>", [
                                'data-id' => $data_id,
                                'public'=>'2',
                                'data-parent_id' => isset($section_obj['parent_id']) ? $section_obj['parent_id'] : 0,
                                'data-action' => 'update',
                                'class' => 'btn btn-primary btn-xs btnCall',
                                'title' => Yii::t('appmenu', 'Edit'),
                                'data-url' => '/sections/private-session-management/update'
                            ]);
                        ?> 
                    </div>
                </div>
                <div class="clearfix"><hr/></div>
                <div id="content-html">                    
                    <?= isset($content_section->content) ? $content_section->content : ''; ?>
                </div> 
            </div>             
        </div>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-header">
            <?php
                echo Html::button("<i class='fa fa-plus'></i>", [
                    'data-id' => $content_section['id'],
                    'public'=>'2',
                    'data-action' => 'create-content',
                    'class' => 'btn btn-success btnCall',
                    'title' => Yii::t('appmenu', 'Create'),
                    'data-url' => '/sections/private-content-management/create'
                ]);
            ?> 
        </div>
        <div class="box-body">
            
            <?php
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $contentProvider,
                    'options' => [
                        'tag' => 'div',
                        'class' => 'content-list',
                        'id' => 'section-all',
                    ],
                    'itemOptions' => function($model) {
                        return ['tag' => 'div', 'data-id' => $model['id'], 'class' => 'box-footer box-comments'];
                    },
                    'layout' => "{items}\n{pager}",
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('_right_content_item', ['model' => $model]);
                    },
                ]);
            ?>
        </div>
    </div>

</div>
<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .box-comments {
        background: #ffffff;
    }
    @media (min-width: 768px){
        .dl-horizontal dt {
            float: left;
            width: 80px;
            overflow: hidden;
            clear: left;
            text-align: right;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .dl-horizontal dd {
            margin-left: 90px;
        }
    }

</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>