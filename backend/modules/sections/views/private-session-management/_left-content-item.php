<?php
    use yii\helpers\Html;
?>

<div class="flex-container">
    <div class="flex-drag">
        <span>            
            <span><i class="fa fa-bars draggable"></i></span>
        </span>        
    </div>
    <div class="flex-2">
        <?php 
            $url = "/sections/private-session-management?id={$model['id']}";
            echo Html::a("<i class='fa {$model['icon']}'></i> {$model['name']}", $url, []);
        ?>         
    </div>
    <div class="">
        <?php
        echo Html::button("<i class='fa fa-pencil'></i>", [
            'data-id' => $model['id'],
            'public'=>'2',
            'data-parent_id' => Yii::$app->request->get('id', '0'),
            'data-action' => 'update-section',
            'class' => 'btn btn-primary btn-xs btnCall',
            'title' => Yii::t('appmenu', 'Edit'),
            'data-url' => '/sections/session-management/update'
        ]);
        echo " ";
        echo Html::button("<i class='fa fa-trash'></i>", [
            'data-id' => $model['id'],
            'public'=>'2',
            'data-parent_id' => Yii::$app->request->get('id', '0'),
            'data-action' => 'delete',
            'class' => 'btn btn-danger btn-xs btnCall',
            'title' => Yii::t('appmenu', 'Delete'),
            'data-url' => '/sections/session-management/delete',
            'data-method' => 'POST'
        ]);
        ?>
    </div> 
</div>

<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    a, a:hover {
        color: #525252;
    }
    .flex-container{
        display: flex;
        padding: 5px;
    }
    .flex-2{
        flex-grow: 2;
    }
    .flex-drag{
        margin-right:5px;
    }
    .flex-container:hover{
        background: #dddde2;
        border-radius: 3px;        
    }
    .flex-2 a{
        display: block;     
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>