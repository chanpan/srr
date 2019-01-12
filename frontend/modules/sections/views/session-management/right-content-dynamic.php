<?php 
    use yii\helpers\Html;
    use yii\widgets\ListView; 
//    appxq\sdii\utils\VarDumper::dump($contentProvider);
  
?>
<div id="dynamic-content">
    <?php 
        echo ListView::widget([
        'id' => 'ezf_dad',
        'dataProvider' => $contentProvider,
        'itemOptions' => ['class' => ''],
        'layout' => "{items}\n{pager}",
        //'layout' => '<div class=" sidebar-nav-title text-right" ></div>{items}<div class="list-pager" style="text-align: center;">{pager}</div>',
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_right-content-dynamic-item', [
                        'model' => $model,
                        'key' => $key,
                        'index' => $index,
                        //'widget' => $widget,
                        'ezf_id' => $model['id'],
            ]);
        },
        'emptyText'=>'',
    ])
    ?>
</div>    
