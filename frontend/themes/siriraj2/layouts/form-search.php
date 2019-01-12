<?php ?>
<?php 
   $controllerID = Yii::$app->controller->id ;
   $actionID = Yii::$app->controller->action->id;
   //\appxq\sdii\utils\VarDumper::dump($actionID);
   $types = frontend\modules\sections\classes\JFiles::getTypeFile();
   
   echo janpan\jn\widgets\CNSearchWidget::widget([
       'data'=>[ 
           'types'=>$types
       ],
       'labelSelect'=> Yii::t('section', 'View by category'),
       'customBtnStyle'=>'
            background: #F9F4B9;
            color: gray;
            font-size: 14pt;
            padding: 7px;
            border: none;
            margin-left: 15px;  
            -webkit-clip-path: polygon(0% 0%, 93% 0, 100% 50%, 93% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 80% 0, 100% 50%, 80% 100%, 0% 100%);
       ',
       'customInputStyle'=>'
           background:#cde4e3;border: none; 
           font-size: 20pt;
           padding: 20px;
           -webkit-clip-path: polygon(6% 0, 100% 2%, 100% 100%, 6% 98%, 0% 50%);
           clip-path: polygon(6% 0, 100% 2%, 100% 100%, 6% 98%, 0% 50%);
           padding-left: 50px;
        ',
       'customDropDownStyle'=>'
            background: #cce4e3;
            font-size: 16pt;
            padding: 5px;
            border: none;
            border-radius: 0px;
            -webkit-clip-path: polygon(6% 0, 100% 1%, 100% 100%, 6% 98%, 0% 50%);
            clip-path: polygon(-4% 0, 100% 0%, 100% 100%, 10% 98%, 0% 50%);
            margin-left: -20px;
            margin-top: -1px;
       '
   ]);
?>
 
<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .ui-menu .ui-menu-item {
        background: white; 
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
<?php    richardfan\widget\JSRegister::begin(); ?>
<script>
    
     
    
</script>
<?php    richardfan\widget\JSRegister::end();?>