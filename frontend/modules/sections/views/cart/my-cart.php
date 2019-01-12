<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
    $this->title = Yii::t('appmenu', 'My Cart');
    if($breadcrumb){
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);  
    }
?>
<div class="col-md-12" id="10" data-id="10" style="padding: 5px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><img src="<?= Url::to('@web/images/cart-icon.png')?>" style="width:25px;"> <?= Html::encode($this->title)?></div>             
        </div>
        <!-- /.box-header -->
        <div class="panel-body" style="">
            <div id="dynamic-content-10">
            <?=                \appxq\sdii\widgets\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                  [
                        'contentOptions'=>['style'=>'width:50px;'],
                        'format'=>'raw',
                        'attribute'=>'image',
                        'label'=> Yii::t('order',''),
                        'value'=>function($model){
                          $file = common\models\Files::findOne($model['id']);
                          
                          if(!empty($file->file_name) && !empty($file->file_path)){
                            $path = "{$file->file_path}/{$file->file_name}";
                            return \yii\helpers\Html::img($path , ['style'=>'width:50px;height: 50px;']);
                          }
                          
                          
                        }
                    ],
                  [
                      'attribute'=>'pro_name',
                      'label'=> Yii::t('cart','Item'),
                      'value'=>'pro_name'
                  ],
//                  [
//                      'attribute'=>'pro_detail',
//                      'label'=> Yii::t('cart','Detail'),
//                      'value'=>'pro_detail'
//                  ],
                  [
                      'contentOptions'=>['style'=>'width:50px;text-align:center;'],
                      'attribute'=>'amount',
                      'label'=> Yii::t('cart','Quantity'),
                      'value'=>'amount'
                  ],
//                  [
//                      'attribute'=>'sum',
//                      'label'=> Yii::t('cart','Price'),
//                      'value'=>function($model){
//                          return number_format($model['sum'], 2);
//                      }
//                  ],
                  [
                        'contentOptions'=>['style'=>'width:50px;text-align:center;'],
                        'class' => 'yii\grid\ActionColumn',
                        'header'=>'',
                        'template'=>'{delete}',
                        'buttons'=>[
                          'delete' => function($url,$model,$key){
                              return Html::a('<i class="fa fa-trash"></i>','#', ['data-id'=>$model['id'], 'class'=>'btn btn-danger btn-sm btn-delete']);
                            }
                        ]
                  ],
                ],
                          
            ]) ?>
            </div>
        </div>
        <!-- /.box-body -->
        <?php if($count):?>
        <div class="panel-footer text-center" style="">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <a href="<?= yii\helpers\Url::to(['/sections/cart/my-check-out?step=1'])?>" class="btn btn-info btn-block btn-lg" style="position: relative;">
                        <img src="<?= Url::to('@web/images/cart-icon.png')?>" style="width:25px;"> <?= Yii::t('cart', 'เขียนคำร้องขอความอนุเคราะห์ข้อมูล')?>
                    </a>
                </div>
            </div>
        </div>
        <?php endif;?>
        <!-- /.box-footer -->
    </div>
</div>
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $('.btn-delete').on('click', function(){
        let id=$(this).attr('data-id');
        let url = '<?= yii\helpers\Url::to(['/sections/cart/delete-cart'])?>';
        
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
    .btn-warning{
        border: solid 1px #da7c0c;
        background: #f78d1d;
        background: -webkit-gradient(linear,left top,left bottom,from(#faa51a),to(#f47a20));
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
