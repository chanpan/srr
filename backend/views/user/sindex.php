<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use common\models\User;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('_user', 'User');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default">
    <div class="box-header">
        
        <div class="col-md-7 pull-left">
            <?php
            ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'method' => 'get', 'action' => Yii::$app->urlManager->createUrl(['user'])]);
            ?>
            <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-10">
                    <?= \yii\helpers\Html::textInput('search', '', ['class' => 'form-control', 'placeholder' => 'ค้นหาผู้ใช้']) ?>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <?= \yii\helpers\Html::submitButton('<i class="fa fa-search"></i> ค้นหา', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <br />
        </div>
        <div class="col-md-5 pull-right text-right">
            <a href="<?= \yii\helpers\Url::to('@web/files/001.xls')?>"><i class="fa fa-download"></i> ดาวน์โหลด Template ตัวอย่าง</a> &nbsp;
            <?= Html::a(Yii::t('backend', '<i class="fa fa-upload"></i> นำเข้าไฟล์ Excel'), ['create'], ['class' => 'btn btn-warning btnImportExcelFile']) ?>
            <?= Html::a(Yii::t('backend', '<i class="fa fa-plus"></i> เพิ่มผู้ใช้'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>    
    </div>
    <div class="box-body">
        <div class="">

            
            
            <?=  appxq\sdii\widgets\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions'=>['class'=>'table table-hover table-bordered table-responsive'],
            'columns' => [
                
                [
                    'contentOptions'=>['style'=>'widh:100px;'],
                    'label' => Yii::t('_user','Email'),
                    'value' => function ($model) {
                        return $model->email;
                    } 
                ], 
                [
                    'contentOptions'=>['style'=>'widh:150px;'],
                    'label' => Yii::t('_user','ชื่อผู้ใช้งาน'),
                    'value' => function ($model) {
                        return $model->username;
                    } 
                ],
                [
                    'contentOptions'=>['style'=>'widh:100px;'],
                    'label' => Yii::t('_user','Firstname'),
                    'value' => function ($model) {
                        return isset($model->userProfile->firstname) ? $model->userProfile->firstname : '';
                    } 
                ],
                [
                    'label' => Yii::t('_user','Lastname'),
                    'contentOptions'=>['style'=>'widh:100px;'],
                    'value' => function ($model) {
                        return isset($model->userProfile->lastname) ? $model->userProfile->lastname : '';
                    } 
                ],         
                [
                    'contentOptions'=>['style'=>'widh:100px;'],
                    'label' => Yii::t('_user','Sap_id'),
                    'value' => function ($model) {
                        return isset($model->userProfile->sap_id) ? $model->userProfile->sap_id : '';
                    } 
                ],
                [
                    'contentOptions' => ['style'=>'width:180px;text-align: center;'],
                    'label' => Yii::t('_user','Site Code'),
                    'value' => function ($model) {
                        return isset($model->userProfile->sitecode) ? $model->userProfile->sitecode : '';
                        
                    } 
                ],  
                        
               [
                   'attribute'=>'role',
                    'contentOptions' => ['style'=>'width:180px;text-align: center;'],
                    'label' => Yii::t('_user','ประเภทผู้ใช้'),
                    'value' => function ($model) {
                        $userRole = Yii::$app->authManager->getRolesByUser($model->id);
                        if(!$userRole){
                            return 'ผู้ใช้ทั่วไป';
                        }
                        $roles = [];
                        foreach($userRole as $v){
                            array_push($roles, $v->description);
                        }
                        return implode(',', $roles);
//                        \appxq\sdii\utils\VarDumper::dump($userRole);
//                        $rows = yii\helpers\ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
//                        \appxq\sdii\utils\VarDumper::dump($rows);
                        
                    } ,'filter'=>array("manager"=>"Manager","users"=>"Users", "administrator"=>'Administrator'),
                ],  
                        
                [
                    'header' => Yii::t('_user', 'approval'),
                    'value' => function ($model) {
                        $auth = Yii::$app->authManager->getAssignment('adminsite', $model->id);

                        if (isset($model->userProfile->approval) && $model->userProfile->approval == 1) {
                            return Html::button('<i class="glyphicon glyphicon-ok"></i>', [
                                        'class' => 'manager-btn btn btn-xs btn-primary',
                                       
                                        'data-id' => $model->id,
                                        'data-action'=>'admin',
                                        'data-url' => yii\helpers\Url::to(['/user/manager', 'id' => $model->id, 'auth' => 'manager'])
                            ]);
                        } else {

                            return Html::button('<i class="glyphicon " style="padding-right: 6px; padding-left: 6px;"></i>', [
                                        'class' => 'manager-btn btn btn-xs btn-default',
//                                        'style'=>'padding: 6px 6px 16px 6px;',
                                        'data-id' => $model->id,
                                        'data-action'=>'admin',
                                        'data-url' => yii\helpers\Url::to(['/user/manager', 'id' => $model->id, 'auth' => 'manager'])
                            ]);
                        }
                    },
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:90px;text-align: center;'],
                ],
                [
                    'contentOptions' => ['style'=>'width:150px;text-align: center;'],
                    'label' => Yii::t('_user', 'อนุมัติโดย'),
                    'value' => function ($model) {
                        $model = common\models\UserProfile::findOne(isset($model->userProfile->approval_by) ? $model->userProfile->approval_by : '0');
                        if($model){
                            return "{$model->firstname} {$model->lastname}";
                        }else{
                            return ' ';
                        }
                    }
                ],
                [
                    'contentOptions' => ['style'=>'width:100px;text-align: center;'],
                    'label' => Yii::t('_user', 'วันที่สมัคร'),
                    'value' => function ($model) {
                       return date('d/m/Y  H:i:s', $model->created_at);

                    }
                ],
        //approval_by
                [
                        'class' => 'appxq\sdii\widgets\ActionColumn',
                        'headerOptions' => ['style'=>'width:80px;text-align: center;'],
                        'contentOptions' => ['style'=>'width:80px;text-align: center;'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                             
                            'update' => function ($url, $model) {
                                $label = Yii::t('section', 'Update');
                                return Html::a('<span class="fa fa-pencil"></span> ', yii\helpers\Url::to(['/user/update', 'id' => $model->id]), [
                                            'title'         => $label,
                                            'class'         => 'btn btn-primary btn-xs',
                                            'data-action'   => 'update',
                                            'data-pjax'     =>0
                                    ]);
                            }, 
                           'delete' => function ($url, $model) {
                                $label = Yii::t('section', 'Delete');
                                return Html::a('<span class="fa fa-trash"></span> ', yii\helpers\Url::to(['/user/delete', 'id' => $model->id]), [
                                            'title'         => $label,
                                            'class'         => 'btn btn-danger btn-xs',
                                            'data-action'   => 'delete',
                                            'data-pjax'     =>0,
                                            'data-confirm'  => Yii::t('section','Are you sure you want to delete this item?'),
                                            'data-method'   => 'post'
                                    ]);
                            },           
                    ]
                ],
            ],
        ]) ?>
        </div>
    </div>
</div>

<?php
    $modal = 'modal-user';
    echo \appxq\sdii\widgets\ModalForm::widget([
        'id' => $modal,
        'size' => 'modal-md',
        'tabindexEnable' => false,
    ]);
?>
 <?php \richardfan\widget\JSRegister::begin();?>
<script>
    $('.btnImportExcelFile').on('click' , function(){
       
       let url = '/user/import-excel';
        $('#<?= $modal?>').modal('show');
        $('#<?= $modal?> .modal-content').html('<i class="fa fa-spinner fa-spin fa-fw"></i>');
        $.get(url,function(data){
            $('#<?= $modal?> .modal-content').html(data); 
        }); 
           
       return false;
    });
    
    $('.manager-btn').click(function(){
        let url = $(this).attr('data-url');
        if($(this).hasClass('btn-default')){
                $(this).removeClass('btn-default');
                $(this).addClass('btn-primary');
                $(this).html('<i class=\'glyphicon glyphicon-ok\'></i>');
            }else{
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-default');
                $(this).html('<i class=\"glyphicon \" style=\"padding-right: 6px; padding-left: 6px;\"></i>');

            } 
        $.get(url, function(result){           
           <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
        });
});
</script>
<?php \richardfan\widget\JSRegister::end();?>