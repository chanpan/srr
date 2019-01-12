<?php

use yii\helpers\Html;
?> 
<div class="product-img">
    <?= Html::img("/images/{$model['image']}", ['class' => 'img img-responsive img-rounded']) ?>
</div>
<div class="product-info">
    <?= $model['pro_name'] ?>    
    <span class="product-description">
        <div>
            <?= $model['pro_detail'] ?>
        </div>
        <div class="pull-right">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>จำนวน</td>
                    <td><?= $model['amount'] ?></td>
                    <td>ราคา</td>
                    <td><?= number_format($model['sum'], 2) ?></td>                    
                    <td><?= $model['amount'] ?></td>
                </tr>
            </table>
             
        </div>
    </span>
</div>
