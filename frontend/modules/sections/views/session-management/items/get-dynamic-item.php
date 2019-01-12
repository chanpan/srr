<?php 
    use yii\widgets\ListView;
?>

<?php
echo ListView::widget([
    'id' => 'ezf_dad',
    'dataProvider' => $dataProvider,
//    'itemOptions' => ['class' => ''],
    'layout' => "{items}\n{pager}",
    'options' => [
        'tag' => 'ul',
        'class' => 'products-list product-list-in-box',
    ],
    'itemOptions' => function($model) {
                return ['tag' => 'li', 'data-id' => $model['id'], 'class' => 'item'];
    },
    'layout' => '<div class=" sidebar-nav-title text-right" ></div>{items}',
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_item', [
                    'model' => $model,
                    'key' => $key,
                    'index' => $index,
                    //'widget' => $widget,
                    'ezf_id' => $model['id'],
        ]);
    },
    'emptyText' => '',
])
?>