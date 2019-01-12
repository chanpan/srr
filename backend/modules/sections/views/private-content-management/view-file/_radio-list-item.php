<?php
    use yii\helpers\Html;
?>
<div style="display: flex;" id="flex-<?= $value?>"/>
    <div style="flex-grow: 2">
        <?php
            echo Html::radio($name, $checked, [
                'value' => $value,
                'label' => Html::encode($label),
                'disabled' => $disabled,
           ]);
         ?>
    </div>
    <div class="button">
        <?php 
            echo Html::button("<i class='fa fa-pencil'></i>", [
                 'data-id' => $value,
                'id'=>"id-{$value}",
                //'data-parent_id' => Yii::$app->request->get('id', '0'),
                'data-action' => 'update-section',
                'class' => 'btn btn-primary btn-xs btnCalls',
                'title' => Yii::t('appmenu', 'Edit'),
                'data-url' => '/sections/file-management/update'
            ]);
            echo " ";
            echo Html::button("<i class='fa fa-trash'></i>", [
                'data-id' => $value,
                'id'=>"id-{$value}",
                'data-action' => 'delete',
                'class' => 'btn btn-danger btn-xs btnCalls',
                'title' => Yii::t('appmenu', 'Delete'),
                'data-url' => '/sections/file-management/delete',
                'data-method' => 'POST'
            ]);
        ?>
    </div>
</div>
 
 

<?php 
    $modal = "modal-contents";
?>
<?php \richardfan\widget\JSRegister::begin();?>

<script>
   $(".btnCalls").on('click', function(){
       let id       = $(this).attr('data-id');
       let url      = $(this).attr('data-url');
       let action   = $(this).attr('data-action');
       let parent_id = $(this).attr('data-parent_id'); 
       let params   = {id:id, parent_id:parent_id};
       if(action == 'delete'){
           delete_form(url , id);
       }else if(action == 'create-choice'){
           let content_id = $(this).attr('content-id');
           let filet_id = $(this).attr('filet-id');
           params['content_id']=content_id;
           params['filet_id']=filet_id;
           console.log(params);
           get_form(url , params);
       }
       else{
           get_form(url , params); 
       }      
       return false; 
   });
   get_form=function(url , params){
       $('#<?= $modal?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
       $('#<?= $modal?>').modal('show');
       $.get(url, params, function(res){
           $('#<?= $modal?> .modal-content').html(res);
       });
   } 
   delete_form=function(url, id){         
        yii.confirm('<?= Yii::t('user', 'Confirm Delete?') ?>', function(){
            $.post(url, {id:id}, function(result){
                <?= appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
                if(result.status == 'success'){
                    $('#flex-'+result['data']['id']).remove();
                }
            });
        });   
    return false;
   }

   
</script>
<?php \richardfan\widget\JSRegister::end();?>