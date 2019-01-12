<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .dad{
        height:100px;
        padding:1px;
        border:1px solid #ecf0f5;
        text-align: center;
        line-height: 100px;
        z-index: 1;
         
    }
    .panel-left, .panel-right{
        background:gray;
        
    }
    #container{
        min-height: 300px;
    }
    #container h1{
        min-height: 300px;
        line-height: 300px;
        text-align: center;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>

<!-- left -->
<div class="col-md-4 panel-left" id="source">
    <div class="row" id="drag-left">
        <?php for($i=1; $i<=12; $i++):?>
            <div class="dad col-md-3" data-id='<?= $i?>'>Demo1 <?= $i?></div>
        <?php endfor; ?>
    </div>
</div>
<div class="col-md-1"></div>
<div class="col-md-6 panel-right">
    <div id="container"><h1>Drop file ตรงนี้</h1></div>
</div>
 

<?php \richardfan\widget\JSRegister::begin() ?>
<script>
    //drag and drop 
    $("#drag-left div").draggable({
        cursor: 'move',
        helper: 'clone',
    });
    $(".panel-right").droppable({
         hoverClass : 'ui-state-highlight',
         accept: ":not(.ui-sortable-helper)",
         cursor: 'move',
        drop: function (event, ui) {
            $('h1').remove();
            $(ui.draggable).removeClass('ui-draggable ui-draggable-handle');
            $('#container').append($(ui.draggable).clone());
        }
    });

    //source 
    $(".panel-right #container").sortable({
        cursor: 'move',
        update:function( event, ui ){
            let dataObj = [];
            $(this).find('.dad').each(function(index){
                dataObj.push($(this).attr('data-id'));
            });
            console.log(dataObj);
        }
     });

</script>
<?php \richardfan\widget\JSRegister::end(); ?>