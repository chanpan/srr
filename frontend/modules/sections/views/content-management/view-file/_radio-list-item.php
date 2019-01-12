<?php
    use yii\helpers\Html;
?>
<div style="display: flex;" id="flex-<?= $value?>">
    <div style="flex-grow: 2">
         
        <?php
            echo Html::radio($name, $checked, [
                'value' => $value,
                'label' => Html::encode($label),
                'disabled' => $disabled,
                'class'=>'check-size'
           ]);
         ?>
    </div>     
</div>
 