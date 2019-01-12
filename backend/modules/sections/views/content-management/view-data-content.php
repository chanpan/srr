<?php 
    \janpan\jn\assets\ListdataAsset::register($this);
    \janpan\jn\assets\EzfToolAsset::register($this);
//    echo $type_id;
?>
<div>
    <?=
        \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'row .ezf_dad',
        //        'id' => 'section-all',
                'id'=>'ezf_dad-'.$type_id,
            ],
            'itemOptions' => function($model) {
                return ['tag' => 'div','id'=>'img-'.$model['id'], 'data-id' => $model['id'], 'class' => 'col-md-2 col-sm-4 text-center item dads-children','style'=>'height: 200px;'];
            },
            'layout' => "{items}\n",
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('view-file/_item', ['model' => $model]);
            },
        ]);
?>
</div>


<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $("#ezf_dad-<?= $type_id?>").sortable({
        update:function( event, ui ){
            let dataObj = [];
            $(this).find('.item').each(function(index){
                dataObj.push($(this).attr('data-id'));
            });
            //console.log(dataObj);
            saveOrder(dataObj);
        }
        //item
    }); 
    function saveOrder(dataObj){
        let dataStr = dataObj.join();
        let url ='<?= yii\helpers\Url::to(['/sections/session-management/forder-files'])?>';
        $.post(url,{data:dataStr}, function(result){
            if(result.status == 'success') {
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
            } else {
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
            } 
        });
        return false;
        
    }
    ///sections/session-management/forder-files
</script>
<?php \richardfan\widget\JSRegister::end(); ?>