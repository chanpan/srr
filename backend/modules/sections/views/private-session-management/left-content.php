<?php

use yii\helpers\Html;
?>
<div class="col-md-3 col-border-right section-left">
    <div class="box-body">
        <div class="text-left">
            <?php
            echo Html::button("<i class='fa fa-plus'></i>", [
                'data-id' => $data_id,
                'data-parent_id' => Yii::$app->request->get('id', '0'),
                'data-action' => 'create-section',
                'public'=>'2',
                'class' => 'btn btn-success btnCall',
                'title' => Yii::t('appmenu', 'Create'),
                'data-url' => '/sections/session-management/create'
            ]);
            ?> 
        </div> <br/>
        <?=
            yii\widgets\ListView::widget([
                'id' => 'ezf_dad',
                'dataProvider' => $dataProvider,                 
                'itemOptions' => function($model){
                    return ['class' => 'item dads-children', 'data-id'=>$model->id];
                },
                'layout' => '<div class=" sidebar-nav-title text-right" ></div>{items}<div class="list-pager" style="text-align: center;">{pager}</div>',
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_left-content-item', [
                                'model' => $model,
                                'key' => $key,
                                'index' => $index,
                                //'widget' => $widget,
                                'ezf_id' => $model['id'],
                    ]);
                },
                //'emptyText'=>'',
                'emptyText'=> \yii\helpers\Html::a('<i class="fa fa-chevron-left"></i> ย้อนกลับ', Yii::$app->request->referrer, ['data-url'=>Yii::$app->request->referrer, 'id'=>'backs','class'=>'', 'style'=>'margin-left:10px;    color: #dddddd;padding:5px;position: absolute;    margin-top: 5px;']),
            ])
        ?>     
    </div>
</div>   

