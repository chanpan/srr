<?php

use yii\bootstrap\Html;
use kartik\tabs\TabsX;

$this->title = Yii::t('section', $title);
if ($breadcrumb) {
    foreach ($breadcrumb as $b) {
        $this->params['breadcrumbs'][] = $b;
    }
}
$modal = "modal-contents";
?>


<div class="row">
    <?= $this->render('_view-file-left', ['dataProvider' => $dataProvider, 'dataDefault' => $dataDefault]) ?>
    <?= $this->render('_view-file-right', ['dataProvider' => $dataProvider, 'dataDefault' => $dataDefault, 'choice'=>$choice]) ?>

</div>
<?php richardfan\widget\JSRegister::begin();?>
<script>
    
    
</script>
<?php richardfan\widget\JSRegister::end();?>
<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    @media (min-width: 992px)
    {
        .col-md-2 {
            width: 15.666667%;            
            margin: 4px;
            border-radius: 3px;
            height: 100px;
            padding-top: 10px;
            padding-left: 25px;
        }
    }
    .box.box-primary {
        border: none;
        box-shadow: 0px 0px 1px #cacaca;
    }
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>