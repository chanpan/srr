<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    $section_obj = \common\models\Sections::findOne($data_id);  
    
     
?>
<div class="col-md-8 section-right"> 
    <?php if($public == '1'): ?>

    <?php endif; ?>
     
    <div class="clearfix"></div>
    <h4>โฟลเดอร์ย่อย</h4>
    <div class="box box-primary">
       
        <div class="box-header text-right">
             
            <?php
                echo Html::button("<i class='fa fa-plus'></i>", [
                    'data-id' => $content_section['id'],
                    'data-action' => 'create-content',
                    'class' => 'btn btn-success btnCall',
                    'title' => Yii::t('appmenu', 'Create'),
                    'data-url' => Url::to(['/sections/content-management/create'])
                ]);
            ?> 
        </div>
        <div class="box-body">
            
            <?php
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $contentProvider,
                    'options' => [
                        'tag' => 'div',
                        'class' => 'content-list',
                        'id' => 'section-all',
                    ],
                    'itemOptions' => function($model) {
                        return ['tag' => 'div', 'data-id' => $model['id'], 'class' => 'dad box-footer box-comments '];
                    },
                    'layout' => "{items}\n{pager}",
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('_right_content_item', ['model' => $model]);
                    },
                ]);
            ?>
        </div>
    </div>

</div>
<?php richardfan\widget\JSRegister::begin();?>
<script>
    $("#section-all").sortable({
        update:function( event, ui ){
            let dataObj = [];
            $(this).find('.dad').each(function(index){
                dataObj.push($(this).attr('data-id'));
                //dataObj[index] = {id:$(this).attr('data-id'), forder:$(this).attr('data-forder')} 
            });
            //console.warn(dataObj);
            saveOrder(dataObj, 'content');
        }
    });
    function saveOrder(dataObj , type){
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

<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .box-comments {
        background: #ffffff;
    }
    @media (min-width: 768px){
        .dl-horizontal dt {
            float: left;
            width: 80px;
            overflow: hidden;
            clear: left;
            text-align: right;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .dl-horizontal dd {
            margin-left: 90px;
        }
    }
    
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>