<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Order */
//appxq\sdii\utils\VarDumper::dump($model->all());
$this->title = Yii::t('order','Order detail');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Orders'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <?php  Pjax::begin(['id'=>'order-view-grid-pjax']);?>
                <?= appxq\sdii\widgets\GridView::widget([
                'tableOptions'=>['id'=>'table-order-detail', 'class'=>'table table-responsive table-bordered table-hover'],    
                'dataProvider' => $dataProvider,
                'rowOptions'=>function($model){
                  return ['id'=>'tb-'.$model->id];  
                },                
                'columns' => [
                    
                    [
                        'contentOptions'=>['style'=>'width:50px;'],
                        'format'=>'raw',
                        'attribute'=>'image',
                        'label'=> Yii::t('order',''),
                        'value'=>function($model){
                          $image = isset($model->files) ? $model->files->file_name_org : '';
                          return \yii\helpers\Html::img("/images/{$image}" , ['style'=>'width:50px;height: 50px;']);
                        }
                    ],
                    [
                        'label'=> Yii::t('order','File name'),
                        'value'=>function($model){
                          $name = isset($model->files) ? $model->files->name : '';
                          return $name;
                        }
                    ],
                    [
                        'label'=> Yii::t('order','Meta text'),
                        'value'=>function($model){
                          $meta_text = isset($model->files) ? $model->files->meta_text : '';
                          return $meta_text;
                        }
                    ],
                    [
                        'label'=> Yii::t('order','Description'),
                        'value'=>function($model){
                            $description = isset($model->files) ? $model->files->description : '';
                          return $description;
                        }
                    ],         
                    [
                        'contentOptions'=>['style'=>'width:50px;'],
                        'attribute'=>'size',
                        'label'=> Yii::t('order','Size'),
                        'value'=>function($model){
                          return $model->size;
                        }
                    ],
                    [
                        'contentOptions'=>['style'=>'width:50px;'],
                        'attribute'=>'quantity',
                        'label'=> Yii::t('order','Quantity'),
                        'value'=>function($model){
                          return  $model->quantity;
                        }
                    ],
                    [
                        'contentOptions'=>['style'=>'width:50px;text-align:center;'],
                        'class' => 'yii\grid\ActionColumn',
                        'header'=>'Action',
                        'template'=>'{delete}',
                        'buttons'=>[
                          'delete' => function($url,$model,$key){
                               $status = isset($model->order->status) ? $model->order->status : '2';
                               return Html::a('<i class="fa fa-trash"></i>','#', ['data-id'=>$model['id'], 'class'=>'btn btn-danger btn-sm btn-delete']);
                               
                            }
                        ]
                  ],
                ],
                          
            ]) ?>
            <?php  Pjax::end();?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        
    </div>
</div>
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $('.btn-delete').on('click', function(){
        let id=$(this).attr('data-id');
        let url = '<?= Url::to(['/order/order-management/delet-order-detail'])?>';
        
        yii.confirm('<?= Yii::t('cart', 'Are you sure you want to delete this item?')?>', function() {
            $.post(url, {id:id}, function(data){
                if(data['status'] == 'success'){
                    <?= \appxq\sdii\helpers\SDNoty::show('data.message', 'data.status') ?>
                    $('#tb-'+id).remove();
                }
            });
        })
        
        
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end();?>