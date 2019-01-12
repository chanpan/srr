<?php 
    $this->title = Yii::t('_app','Water mark image template');    
    $this->params['breadcrumbs'][] = $this->title;
    use yii\widgets\Pjax;
?>
<?php 
    $modalId = 'modal-mark';
    echo \appxq\sdii\widgets\ModalForm::widget([
        'id' => $modalId,
        'size' => 'modal-lg',
        'tabindexEnable' => false,
    ]);
?>
<div class="box box-primary">
    <div class="box-header"></div>
    <div class="box-body">
        <?php Pjax::begin(['id' => 'pjax-water']);?>
        <?=        \appxq\sdii\widgets\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [                 
                [
                    'contentOptions'=>['style'=>'width:100px'],
                    'format'=>'raw',
                    'attribute'=>'name',
                    'label'=>Yii::t('file','Image'),
                    'value'=>function($model){
                        
                        $src = Yii::getAlias('@storageUrl')."{$model->path}/{$model->name}";                        
                        return yii\helpers\Html::img($src,['style'=>'width:80px']);
                    }
                ],
                [
                    'contentOptions'=>['style'=>'width:100px'],
                    'attribute'=>'name',
                    'label'=> Yii::t('file','File name'),
                    'value'=>function($model){
                        return $model->name;
                    }
                ],
                [
                    'contentOptions'=>['style'=>'width:100px'],
                    'format'=>'raw',
                    'attribute'=>'default',
                    'label'=>Yii::t('file','Default'),
                    'value'=>function($model){
                        if($model->default == 1){
                            return "<div class='label label-success'>".Yii::t('file','Yes')."</div>";
                        }else{
                           return "<div class='label label-warning'>".Yii::t('file','No')."</div>";  
                        }
                    }
                ],[ 
                    'attribute'=>'Detail',
                    'label'=> Yii::t('file','Detail'),
                    'value'=>function($model){
                        return $model->detail;
                    }
                ],[ 
                    'attribute'=>'Code',
                    'label'=> Yii::t('file','Code'),
                    'value'=>function($model){
                        return $model->code;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',  // the default buttons + your custom button
                    'buttons' => [
                        'update' => function($url, $model, $key) {     // render your custom button
                            return yii\helpers\Html::a("<i class='fa fa-edit'></i>", '#', ['data-url'=>$url,'class'=>'btn btn-primary', 'data-action'=>'update']);
                        }
                    ]
                ]        
            ],
        ]) ?>
        <?php \richardfan\widget\JSRegister::begin();?>
            <script>
                $('.btn').on('click', function(){
                    let url = $(this).attr('data-url');
                    $('#<?= $modalId?>').modal('show');
                    $('#<?= $modalId?> .modal-content').html('<i class="fa fa-spinner fa-spin fa-fw"></i>');
                    $.get(url,{type:2}, function(data){
                        $('#<?= $modalId?> .modal-content').html(data); 
                    });
                   return false; 
                });
            </script>
        <?php \richardfan\widget\JSRegister::end();?>
        <?php Pjax::end();?>
    </div>
    <div class="box-footer"></div>
</div>

