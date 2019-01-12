<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
    $this->title = Yii::t('appmenu', 'รายการเขียนคำร้องขอความอนุเคราะห์ข้อมูล');
    if($breadcrumb){
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);  
    }
?>
<div class="row"> 
<div class="col-md-12" id="10" data-id="10" style="padding: 5px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><img src="<?= Url::to('@web/images/cart-icon.png')?>" style="width:25px;"> <?= Html::encode($this->title);?></div>              
        </div>
        <!-- /.box-header -->
        <div class="panel-body" style="">
            <div id="dynamic-content-10">
            <?=                \appxq\sdii\widgets\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                  [
                      'format'=>'raw',
                      'contentOptions'=>['style'=>'width:250px;'],
                      'attribute'=>'id',
                      'label'=> Yii::t('order','Order Id'),
                      'value'=>function($model){
                        return Html::a("{$model->id}", ["/sections/order/order-detail?order_id={$model->id}"], ['']);                        
                      }
                  ],
                  [
                    
                      'attribute'=>'create_date',
                      'label'=> Yii::t('order','Date'),
                      'value'=>function($model){
                        return appxq\sdii\utils\SDdate::mysql2phpThDateSmall(isset($model->create_date) ? $model->create_date : '2018-00-00');
                      }
                  ],
                  [
                        'format'=>'raw',
                        'attribute'=>'create_date',
                        'label'=>'สถานะ',
                        'value'=>function($model){

                            $items = ['1'=>'รอพิจารณา' , '2'=>'ส่งข้อมูลแล้ว', '3'=>'ไม่อนุมัติ', '100'=>''];
                            if(isset($model->status)){
                                return $items[$model->status];
                            }else{
                                return $items[100];
                            }
                        },      
                    ], 
                [
                    'format' => 'raw',
                    'attribute' => 'conditions',
                    'label' => 'หมายเหตุ',
                    'value' => function($model) {
                            return isset($model['conditions']) ? $model['conditions'] : '';
                    },
                ],        
//                  [
//                    
//                      'attribute'=>'status',
//                      'label'=> Yii::t('order','Status'),
//                      'value'=>function($model){
//                        if($model->status == 1){
//                            return 'ยังไม่ชำระเงิน';
//                        }else if($model->status == 2){
//                            return 'ชำระเงินแล้ว';
//                        }
//                      }
//                  ],
                  [
                        'contentOptions'=>['style'=>'width:300px;text-align:center;'],
                        'class' => 'yii\grid\ActionColumn',
                        'header'=>'',
                                                                    'template'=>'{preview} {send-mail} {print} {delete}', //{request}
                        'buttons'=>[
                          'request' => function($url,$model,$key){                               
                             return Html::a('แก้ไขคำร้อง', Url::to(['/sections/order/add-request']), ['title'=>Yii::t('order','แก้ไขคำร้อง'),'data-id'=>$model['id'], 'class'=>'btns btn btn-success btn-xs btn-add-request']);
                          }, 
//                          'preview' => function($url,$model,$key){                               
//                             return Html::a('<i class="fa fa-eye"></i>', Url::to(['/sections/order/print?id='])."{$model['id']}&type=preview", ['title'=>Yii::t('order','Preview'),'data-id'=>$model['id'], 'class'=>'btns btn btn-info btn-xs', 'target'=>'_blank']);   
//                          },  
//                          'send-mail' => function($url,$model,$key){
//                              
//                                  return Html::a('<i class="fa fa-envelope"></i>',Url::to(['/sections/order/print?id='])."{$model['id']}&type=mail", ['title'=> Yii::t('order','Send Email'),'data-id'=>$model['id'], 'class'=>'btns btn btn-success btn-xs', 'target'=>'_blank' ]);
//                               
//                          },
                          'print' => function($url,$model,$key){                               
                             return Html::a('แสดงตัวอย่างแบบฟอร์ม',$url."&type=print", ['title'=>Yii::t('order','Print'),'data-id'=>$model['id'], 'class'=>'btns btn btn-primary btn-xs', 'target'=>'_blank']);   
                          },        
                          'delete' => function($url,$model,$key){
                              if($model['status'] == 1){
                                  return Html::a('<i class="fa fa-trash"></i> ลบ','#', ['data-id'=>$model['id'],'title'=>Yii::t('order','Delete'), 'class'=>'btns btn btn-danger btn-xs btn-delete']);
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


</div>

<?php 
    $modalId = 'modal-request';
    echo yii\bootstrap\Modal::widget([
        'id'=>$modalId,
        'size'=>'modal-lg',
        'options'=>['tabindex' => false]
   ]);
?>    
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $('.btn-add-request').on('click', function(){
       let id = $(this).attr('data-id');
       let url = $(this).attr('href');
       $('#<?= $modalId ?>').modal('show');
       $('#<?= $modalId ?> .modal-content').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-fw"></i></div>');
       $.get(url,{id:id},function(data){
            $('#<?= $modalId ?> .modal-content').html(data); 
       });
       return false;
    });
    $('.btn-delete').on('click', function(){
        let id=$(this).attr('data-id');
        let url = '<?= Url::to(['/sections/order/delet-order'])?>';
        
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
<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .btns{
        font-size:14pt;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
