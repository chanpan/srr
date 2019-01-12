<?php 
    use yii\helpers\Html;
    $this->title = Yii::t('order', 'Order Detail');
    if($breadcrumb){
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);  
    }
    
?>
<div class="col-md-12" id="10" data-id="10" style="padding: 5px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><i class="fa fa-shopping-cart"></i> <?= Html::encode($this->title);?></div>             
        </div>
        <!-- /.box-header -->
        <div class="panel-body" style="">
            <div id="dynamic-content-10">
            <?= yii\grid\GridView::widget([
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
                          }else{
                              return '';
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
                        'header'=>'',
                        'template'=>'{delete}',
                        'buttons'=>[
                          'delete' => function($url,$model,$key){
                               $status = isset($model->order->status) ? $model->order->status : '2';
                               if($status == 1){
                                  return Html::a('<i class="fa fa-trash"></i>','#', ['data-id'=>$model['id'], 'class'=>'btn btn-danger btn-sm btn-delete']);
                              }
                            }
                        ]
                  ],
                ],
                          
            ]) ?>
            </div>
        </div>
        
    </div>
</div>

<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $('.btn-delete').on('click', function(){
        let id=$(this).attr('data-id');
        let url = '<?= yii\helpers\Url::to(['/sections/order/delet-order-detail'])?>';
        
        yii.confirm('<?= Yii::t('cart', 'Are you sure you want to delete this item?')?>', function() {
            $.post(url, {id:id}, function(data){
                if(data['status'] == 'success'){
                    <?= \appxq\sdii\helpers\SDNoty::show('data.message', 'data.status') ?>
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            });
        })
        
        
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end();?>


<?php \appxq\sdii\widgets\CSSRegister::begin()?>
<style>
    @media only screen and (min-width: 768px){
        .cd-breadcrumb, .cd-multi-steps {     
            max-width: 100%;    
            margin-left: 0; 
        }
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>