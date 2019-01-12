<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

?>

<?=
ListView::widget([
    'id' => 'ezf_dad',
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item dads-children'],
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
    'emptyText'=> \yii\helpers\Html::a('<i class="fa fa-chevron-left"></i> ย้อนกลับ', Yii::$app->request->referrer, ['data-url'=>Yii::$app->request->referrer, 'id'=>'backs','class'=>'', 'style'=>'margin-left:10px;    color: #dddddd;padding:5px;position: absolute;    margin-top: 5px;']),
])
?>






<?php appxq\sdii\widgets\CSSRegister::begin();?>
<style>
/*    .list-view .item a.media { 
        border-bottom-style: dashed;
    }
    .items-sidebar.navbar-collapse{ 
        background-color: #fff; 
    }
    .list-view .item a.media{
        padding: 5px;         
        font-size: 14px;
    }
    @media (min-width: 768px){
        .items-sidebar.navbar-collapse{
            width: 245px;
        }
        .content-wrapper { 
            background-color: #ffffff;
        }
    }
    @media (min-width: 992px)
    {
        .col-md-offset-2 {
            margin-left: 17.5%;
        }
    }*/
.dads-children:hover {
    background-color: #222d32;
}
</style>
<?php appxq\sdii\widgets\CSSRegister::end();?>