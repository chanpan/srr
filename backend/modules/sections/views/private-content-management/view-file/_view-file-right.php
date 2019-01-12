<?php 
    use yii\helpers\Html;
?>
<div class="col-md-4 view-file-right">
    <div class="box box-primary">
        <div class="box-body">
            <label>
        <i class="fa fa-info-circle" aria-hidden="true"></i> คำอธิบาย
    </label>
    <div class="border-bottom">
        <small><?= $dataDefault['description'] ?></small>
    </div>     
    <div class="border-bottom">
        <label>
            <i class="fa fa-user" aria-hidden="true"></i> ภาพโดย : <?= \common\modules\cores\User::getProfileNameByUserId($dataDefault['user_create']) ?> s
        </label>    
    </div>
     
            <div style="margin-top:20px;">
        <div>
            <?php
            echo Html::button("<i class='fa fa-plus'></i>", [
                'content-id' => isset($_GET['content_id']) ? $_GET['content_id'] : '',
                'filet-id'=> isset($_GET['filet_id']) ? $_GET['filet_id'] : '',
                'data-action' => 'create-choice',
                'class' => 'btn btn-success btnCalls',
                'title' => Yii::t('appmenu', 'Add'),
                'data-url' => '/sections/file-management/create'
            ]);
            ?> 
        </div>
        
         
        <?php
        
        //appxq\sdii\utils\VarDumper::dump($dataDefault);
        $name       = "radiotest";
        $items      = yii\helpers\ArrayHelper::map($choice, 'id', 'label');
        $default    = backend\modules\sections\classes\JContent::getChoiceDefault($dataDefault['content_id']);
        $selection = isset($default['id']) ? $default['id'] : '1';         
        echo Html::label(Yii::t('file','Size'));
        echo Html::radioList($name, $selection, $items, [
            'item' => function ($index, $label, $name, $checked, $value) {
                $disabled = false;  
                return $this->render('_radio-list-item',[
                    'index'=>$index,
                    'label'=>$label,
                    'name'=>$name,
                    'checked'=>$checked,
                    'value'=>$value,
                    'disabled'=>$disabled
                ]);                
            },
        ]);
        ?>
    </div>
        </div>
    </div>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
   .view-file-right{      
     padding:5px;   
   }
   .border-bottom{
        border-bottom: 1px solid #ecf0f5;
        border-bottom-style: dashed;
        padding-bottom: 10px;
        padding-top: 10px;
   }
</style>
<?php appxq\sdii\widgets\CSSRegister::end();?>

<?php 
    $modal = "modal-contents";
?>
