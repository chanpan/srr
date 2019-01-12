<?php ?>
<?php 
   $controllerID = Yii::$app->controller->id ;
   $actionID = Yii::$app->controller->action->id;
   //\appxq\sdii\utils\VarDumper::dump($actionID);
?>
<div class="categorie-search-box">
    <form id="formSearch" class='ui-widget'>
        <div class="form-group">
            <select class="bootstrap-select" id="select-type-search" name="poscats">
                <option value="0"><?= Yii::t('section', 'Browse by Category') ?></option>
                <?php foreach ($type as $t) { ?>
                <option value="<?= $t['id'] ?>" data-id='<?= $t['id'] ?>'><?= Yii::t('section',$t['name']) ?></option>                                     
                <?php } ?>                               
            </select>
        </div>
        
        <input type="text" name="search" id="text_search_params" placeholder="<?= Yii::t('section', 'Search Images') ?>">
        <button><i class="lnr lnr-magnifier"></i></button>
        
    </form>
</div>
<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .ui-menu .ui-menu-item {
        background: white; 
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
<?php    richardfan\widget\JSRegister::begin(); ?>
<script>
    $( "#text_search_params" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "/sections/session-management/get-keyword-search",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        } );
      },
      minLength: 2,
      select: function( event, ui ) {
        //log( "Selected: " + ui.item.value + " aka " + ui.item.id );
        let url = "/sections/session-management/search?type_id="+0+"&txtsearch="+ui.item.value;
        let actionID = "<?= $actionID?>";
        
        if(actionID == "search"){
           window.open(url,'_parent');
        }else{
            window.open(url,'_blank');  
        }
      }
    } );
     
    
</script>
<?php    richardfan\widget\JSRegister::end();?>