<?php 
    use yii\helpers\Html;
    $this->title = Yii::t('order', 'Order Detail');
    
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?= Html::encode($this->title)?></h4>
</div>
<div class="modal-body">
    <?=    yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'contentOptions'=>['style'=>'width:50px;'],
                        'format'=>'raw',
                        'attribute'=>'image',
                        'label'=> Yii::t('order',''),
                        'value'=>function($model){
                          if(!empty($model->files->file_name) && !empty($model->files->file_path)){
                            $path = "{$model->files->file_path}/{$model->files->file_name}";
                            return \yii\helpers\Html::img($path , ['style'=>'width:50px;height: 50px;']);
                          }
                          
                        }
                    ],
                    [
                        'label'=> Yii::t('order','File name'),
                        'value'=>function($model){
                          $name = isset($model->files) ? $model->files->file_name_org : '';
                          return $name;
                        }
                    ],                   
//                    [
//                        'label'=> Yii::t('order','details'),
//                        'value'=>function($model){
//                            $description = isset($model->files) ? $model->files->description : '';
//                          return $description;
//                        }
//                    ],         
                     
                    [
                        'contentOptions'=>['style'=>'width:100px;'],
                        //'attribute'=>'quantity',
                        'label'=> Yii::t('order','Quantity'),
                        'value'=>function($model){
                          return  $model->quantity;
                        }
                    ],
                    
                ],
                          
            ]) ?>
</div>

 