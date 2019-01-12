<?php
    
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\Url;
    use appxq\sdii\widgets\GridView;
    use appxq\sdii\widgets\ModalForm;
    use appxq\sdii\helpers\SDNoty;
    use appxq\sdii\helpers\SDHtml;
    use \yii\web\JsExpression;
    
    /* @var $this yii\web\View */
    /* @var $searchModel backend\modules\order\models */
    /* @var $dataProvider yii\data\ActiveDataProvider */
    
    $this->title = Yii::t('appmenu', 'Order Management');
    $this->params['breadcrumbs'][] = $this->title;
    
    ?>
<div class='text-right' style='margin-bottom:10px;'>
<a class='btn btn-default btnViewDelete' href='<?= Url::to(['/order/order-management'])?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> กลับไปหน้าดูคำร้อง</a>
</div>
<div class="panel panel-primary">

<div class="panel-heading">
<img src="<?= Url::to('@web/images/cart-icon.png')?>" style="width:25px;"> <?=  Html::encode($this->title) ?>
</div>
<div class="panel-body">
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php  Pjax::begin(['id'=>'order-grid-pjax']);?>
<?= GridView::widget([
                     'id' => 'order-grid',
                     //'panelBtn' => Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['/order/order-management/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-order', 'disabled'=>true]),
                     'dataProvider' => $dataProvider,
                     'filterModel' => $searchModel,
                     'columns' => [
                     //        [
                     //        'class' => 'yii\grid\CheckboxColumn',
                     //        'checkboxOptions' => [
                     //            'class' => 'selectionOrderIds'
                     //        ],
                     //        'headerOptions' => ['style'=>'text-align: center;'],
                     //        'contentOptions' => ['style'=>'width:40px;text-align: center;'],
                     //        ],
                     [
                     'class' => 'yii\grid\SerialColumn',
                     'headerOptions' => ['style'=>'text-align: center;'],
                     'contentOptions' => ['style'=>'width:60px;text-align: center;'],
                     ],
                     [
                     'format' => 'raw',
                     'contentOptions' => ['style' => 'width:160px;'],
                     'attribute' => 'id',
                     'label' => Yii::t('order', 'Order Id'),
                     'value' => function($model) {
                     return $model->id;
                     //return Html::a("{$model->id}", ["/order/order-management/order-detail?order_id={$model->id}"], ['class'=>'order_details', 'data-id'=>$model->id]);
                     }
                     ],
                     [
                     'contentOptions' => ['style' => 'width:160px;'],
                     'attribute'=>'user_id',
                     'label'=> Yii::t('order', 'Name'),
                     'value'=>function($model){
                     $name = "";
                     if(isset($model->user->userProfile)){
                     $name = $model->user->userProfile->firstname. " " . $model->user->userProfile->lastname;
                     }
                     
                     return $name;
                     },
                     'filter' => \kartik\select2\Select2::widget([
                                                                 'model' => $searchModel,
                                                                 'attribute' => 'user_id',
                                                                 'data' => yii\helpers\ArrayHelper::map(common\models\UserProfile::find()->select(['user_id','concat(firstname,"  ", lastname) as name'])->asArray()->limit(50)->all(),'user_id','name'),
                                                                 'hideSearch' => false,
                                                                 'pluginOptions' => [
                                                                 'allowClear' => true,
                                                                 'minimumInputLength' => 3,
                                                                 'ajax' => [
                                                                 
                                                                 'url' => Url::to(['/order/order-management/get-user']),
                                                                 
                                                                 'dataType' => 'json',
                                                                 
                                                                 'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                                                                 
                                                                 'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                                 
                                                                 ],],
                                                                 'options' => [
                                                                 'id'=> appxq\sdii\utils\SDUtility::getMillisecTime(),
                                                                 'style'=>'width:100%',
                                                                 'placeholder' => Yii::t('order', 'Search for name'),
                                                                 ]
                                                                 ]),
                     
                     ],
                     [
                     'format'=>'raw',
                     'attribute'=>'create_date',
                     'label'=>'วันที่ขอความอนุเคราะห์',
                     'value'=>function($model){
                     //                    return appxq\sdii\utils\SDdate::mysql2phpDate($model->create_date);
                     return \appxq\sdii\utils\SDdate::mysql2phpDate($model->create_date);//appxq\sdii\utils\SDdate::mysql2phpThDateSmall($model->create_date);
                     },
                     'filter' => \yii\jui\DatePicker::widget([
                                                             'model'=>$searchModel,
                                                             'attribute'=>'create_date',
                                                             'language' => 'th',
                                                             'dateFormat' => 'yyyy-MM-dd',
                                                             'options'=>['class'=>'form-control']
                                                             ]),
                     ],
                     [
                     'format'=>'raw',
                     'attribute'=>'status',
                     'label'=>'สถานะ',
                     'value'=>function($model){
                     
                     $items = ['1'=>'รอ' , '2'=>'ส่งข้อมูลแล้ว', '3'=>'ไม่อนุมัติ', '100'=>''];
                     if(isset($model->status)){
                     return $items[$model->status];
                     }else{
                     return $items[100];
                     }
                     },
                     'filter'=>['1'=>'รอ' , '2'=>'ส่งข้อมูลแล้ว', '3'=>'ไม่อนุมัติ', '100'=>''],
                     ],
                     [
                     'format' => 'raw',
                     'attribute' => 'conditions',
                     'label' => 'หมายเหตุ',
                     'value' => function($model) {
                     return isset($model['conditions']) ? $model['conditions'] : '';
                     },
                     ],
                     [
                     'format' => 'raw',
                     'attribute' => 'admin_id',
                     'label' => 'ลบโดย',
                     'value' => function($model) {
                     $model = \common\models\User::findOne($model->admin_id);
                     $name = '';
                     if($model){
                     $fname = isset($model->userProfile->firstname) ? $model->userProfile->firstname : '';
                     $lname = isset($model->userProfile->lastname) ? $model->userProfile->lastname : '';
                     $name = "{$fname} {$lname}";
                     
                     }
                     return $name;
                     
                     // return $model->admin_id;
                     },
                     'filter' => \kartik\select2\Select2::widget([
                                                                 'model' => $searchModel,
                                                                 'attribute' => 'admin_id',
                                                                 'data' => yii\helpers\ArrayHelper::map(common\models\UserProfile::find()->select(['user_id', 'concat(firstname,"  ", lastname) as name'])->asArray()->limit(50)->all(), 'user_id', 'name'),
                                                                 'hideSearch' => false,
                                                                 'pluginOptions' => [
                                                                 'allowClear' => true,
                                                                 'minimumInputLength' => 3,
                                                                 'ajax' => [
                                                                 
                                                                 'url' => Url::to(['/order/order-management/get-user']),
                                                                 
                                                                 'dataType' => 'json',
                                                                 
                                                                 'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                                                                 
                                                                 'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                                 
                                                                 ],],
                                                                 'options' => [
                                                                 'id' => appxq\sdii\utils\SDUtility::getMillisecTime(),
                                                                 'style' => 'width:100%',
                                                                 'placeholder' => Yii::t('order', 'Search for name'),
                                                                 ]
                                                                 ]),
                     ],
                     
                     
                     
                     
                     [
                     'format' => 'raw',
                     'attribute' => 'update_date',
                     'label' => 'วันที่ลบ',
                     'contentOptions' => ['style' => 'width:100px;'],
                     'value' => function($model) {
                     if(isset($model->send_date)){
                            return \appxq\sdii\utils\SDdate::mysql2phpDate($model->update_date); //appxq\sdii\utils\SDdate::mysql2phpThDateTime($model->send_date);
                     }
                     return '';
                     },
                     'filter' => \yii\jui\DatePicker::widget([
                                                             'model'=>$searchModel,
                                                             'attribute'=>'update_date',
                                                             'language' => 'th',
                                                             'dateFormat' => 'yyyy-MM-dd',
                                                             'options'=>['class'=>'form-control']
                                                             ]),
                     
                     ],
                     [
                     'class' => 'appxq\sdii\widgets\ActionColumn',
                     'contentOptions' => ['style'=>'width:300px;text-align: center;'],
                     'template' => '{restore} ',
                     'headerOptions' => ['style' => 'width:300px'],
                     'buttons' => [
                     
                     'confirm' => function ($url, $model) {
                     $label = Yii::t('section', 'แก้ไข');
                     return Html::a('<span class="fa fa-pencil"> แก้ไขสถานะ</span> ', yii\helpers\Url::to(['/order/order-management/update', 'id' => $model->id]), [
                                    'title'         => $label,
                                    'class'         => 'btn btn-primary btn-xs btnEdit',
                                    'data-action'   => 'edit',
                                    'data-pjax'     =>0
                                    ]);
                     },
                     'print' => function ($url, $model) {
                     $label = Yii::t('section', 'แก้ไข');
                     return Html::a('<span class="fa fa-print"> ปริ้นคำร้อง</span> ', yii\helpers\Url::to(['/order/order-management/download', 'id' => $model->id]), [
                                    'title'         => $label,
                                    'class'         => 'btn btn-warning btn-xs btnPrint',
                                    'data-action'   => 'edit',
                                    'data-pjax'     =>0,
                                    'data-id'       =>$model->id
                                    ]);
                     },
                     'update' => function ($url, $model) {
                     $label = Yii::t('section', 'Update');
                     return Html::a('<span class="fa fa-pencil"></span> ', yii\helpers\Url::to(['/order/order-management/update', 'id' => $model->id]), [
                                    'title'         => $label,
                                    'class'         => 'btn btn-primary btn-xs',
                                    'data-action'   => 'update',
                                    'data-pjax'     =>0
                                    ]);
                     },
                     'download' => function ($url, $model) {
                     
                     return Html::a('<span class="fa fa-eye"> ดูคำร้อง</span> ', yii\helpers\Url::to(['/order/order-management/view-request', 'id' => $model->id]), [
                                    'title'         => 'ดูคำร้อง',
                                    'class'         => 'btn btn-success btn-xs',
                                    'data-action'   => 'download',
                                    'data-pjax'     =>0
                                    ]);
                     },
                     'restore' => function ($url, $model) {
                     $label = Yii::t('section', 'กู้คืน');
                     return Html::a('<span class="fa fa-refresh"></span> '.Yii::t('order','กู้คืน'), yii\helpers\Url::to(['/order/order-management/un-delete', 'id' => $model->id]), [
                                    'title'         => $label,
                                    'data-id'       =>$model->id,
                                    'class'         => 'btn btn-info btn-xs btnDeleteItems',
                                    'data-action'   => 'delete',
                                    'data-pjax'     =>0,
                                    'data-confirm'  => Yii::t('section','Are you sure you want to delete this item?'),
                                    'data-method'   => 'post'
                                    ]);
                     },
                     ]
                     ],
                     ],
                     ]); ?>
<?php  Pjax::end();?>
</div>

</div>

<?=  ModalForm::widget([
                       'id' => 'modal-order',
                       'size'=>'modal-lg',
                       ]);
?>
<?php  \richardfan\widget\JSRegister::begin([
                                            //'key' => 'bootstrap-modal',
                                            'position' => \yii\web\View::POS_READY
                                            ]); ?>
<script>
//btnDownload

//btnPrint
$('.btnPrint').on('click', function(){
                  let url = $(this).attr('href');
                  let id = $(this).attr('data-id');
                  $.get(url, {id:id}, function(result){
                        if(result.status == 'success') {
                        <?= SDNoty::show('result.message', 'result.status')?>
                        // console.log(result);
                        // $('#downloadFile').attr('href', result['data']['filename']);
                        let uri = `${result['data']['path']}/${result['data']['filename']}`;
                        window.open(uri, '_BLANK');
                        } else {
                        <?= SDNoty::show('result.message', 'result.status')?>
                        }
                        });
                  return false;
                  });


$('.btnDownload').on('click', function(){
                     let url = $(this).attr('href');
                     let id = $(this).attr('data-id');
                     $.post(url, {id:id}, function(result){
                            if(result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            // console.log(result);
                            // $('#downloadFile').attr('href', result['data']['filename']);
                            let uri = `${result['data']['path']}/${result['data']['filename']}`;
                            window.open(uri, '_BLANK');
                            } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            }
                            });
                     return false;
                     });
$('.btnDeleteItems').on('click', function(){
                        let url = $(this).attr('href');
                        let id = $(this).attr('data-id');
                        yii.confirm('<?= Yii::t('app', 'ยืนยันการทำรายการ')?>', function() {
                                    $.post(url, {id:id}, function(result){
                                           if(result.status == 'success') {
                                           <?= SDNoty::show('result.message', 'result.status')?>
                                           setTimeout(function(){
                                                      location.reload();
                                                      },1000);
                                           } else {
                                           <?= SDNoty::show('result.message', 'result.status')?>
                                           }
                                           });
                                    });
                        //modalOrder(url);
                        return false;
                        });
$('.btnEdit').on('click' ,function(){
                 let url = $(this).attr('href');
                 modalOrder(url);
                 return false;
                 });
function selectionOrderGrid(url) {
    yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete these items?')?>', function() {
                $.ajax({
                       method: 'POST',
                       url: url,
                       data: $('.selectionOrderIds:checked[name=\"selection[]\"]').serialize(),
                       dataType: 'JSON',
                       success: function(result, textStatus) {
                       if(result.status == 'success') {
                       <?= SDNoty::show('result.message', 'result.status')?>
                       $.pjax.reload({container:'#order-grid-pjax'});
                       } else {
                       <?= SDNoty::show('result.message', 'result.status')?>
                       }
                       }
                       });
                });
}
//$('.btnViewDelete').on('click', function(){
//                       let url = '<?= Url::to(['/order/order-management/view-delete'])?>';
//                       $('#modal-order .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
//                       $('#modal-order').modal('show');
//                       $.get(url , function(res){
//                             $('#modal-order .modal-content').html(res);
//                             });
//                       return false;
//                       });

function modalOrder(url) {
    $('#modal-order .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-order').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>
