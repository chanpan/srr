<?php
$this->title = Yii::t('section', 'Section');
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
?>
<div class="col-md-4 col-border-right section-left">
    <h4>โฟลเดอร์หลัก</h4>
    <div class="box box-primary">
        <div class="box-body">
        <div class="text-right">
            <?php
            echo Html::button("<i class='fa fa-plus'></i>", [
                'data-id' => $data_id,
                'data-parent_id' => Yii::$app->request->get('id', '0'),
                'data-action' => 'create-section',
                'class' => 'btn btn-success btnCall',
                'title' => Yii::t('appmenu', 'Create'),
                'data-url' => Url::to(['/sections/session-management/create'])
            ]);
            ?> 
        </div> <br/>
        <?=
            ListView::widget([
                'id' => 'ezf_dad',
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'id' => 'sections',
                ],
                'itemOptions' => function($model){
                    return ['class' => 'dad', 'data-id'=>$model->id];
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
                'emptyText'=> \yii\helpers\Html::a('<i class="fa fa-chevron-left"></i> '. Yii ::t('section','Back'), Yii::$app->request->referrer, ['data-url'=>Yii::$app->request->referrer, 'id'=>'backs','class'=>'', 'style'=>'margin-left:10px;    color: #6d6b6b;padding:5px;margin-top: 5px;']),
            ])
            ?>  
    </div>
    </div>
</div>   

<?php richardfan\widget\JSRegister::begin();?>
<script>
    $("#sections").sortable({
        update:function( event, ui ){
            let dataObj = [];
            $(this).find('.dad').each(function(index){
                dataObj.push($(this).attr('data-id'));
                //dataObj[index] = {id:$(this).attr('data-id'), forder:$(this).attr('data-forder')} 
            });
            //console.warn(dataObj);
            saveOrder(dataObj, 'section');
        }
    });
    function saveOrder(dataObj, type){
        let dataStr = dataObj.join();
        let url ='<?= Url::to(['/sections/session-management/order-content'])?>';
        $.post(url,{data:dataStr, type:type}, function(result){
            console.log(result);
            if(result.status == 'success') {
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
            } else {
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
            } 
        });
        return false;
        
    }
</script>
<?php richardfan\widget\JSRegister::end();?>