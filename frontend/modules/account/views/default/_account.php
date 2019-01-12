<div class="setting-account">
    <label><i class="fa fa-user-o"></i> <?= Yii::t('user','Username')?> : <?= $model->username;?></label>
</div>
<div class="setting-account">    
    <label><i class="fa fa-envelope-o"></i> <?= Yii::t('user','Email')?> : <?= $model->email;?></label>
</div>
<div class="setting-account">    
    <label><i class="fa fa-calendar"></i> <?= Yii::t('user','Create Date')?> : <?= appxq\sdii\utils\SDdate::mysql2phpDate(date('Y-m-d', $model->created_at));?></label>
</div>

<div class="setting-account">    
  <?= \yii\helpers\Html::a('<i class="fa fa-key"></i> '.Yii::t('user', 'Change password'), ['password'], ['class' => '','style'=>'margin-top:-3px;']) ?>
</div>
 

