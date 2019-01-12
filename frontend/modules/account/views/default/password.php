<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\account\models\PasswordForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('user', 'Change password');
if($breadcrumb){
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);  
    }
 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('user', 'Submit'), ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end() ?>
    </div>
</div>
    </div>
</div>
<?php \appxq\sdii\widgets\CSSRegister::begin()?>
<style>
    @media only screen and (min-width: 768px){
        .cd-breadcrumb, .cd-multi-steps {     
            max-width: 100%;    
            margin-left: 0; 
        }
    }
    .btn-warning{
        border: solid 1px #da7c0c;
        background: #f78d1d;
        background: -webkit-gradient(linear,left top,left bottom,from(#faa51a),to(#f47a20));
    }
    #w3-success{
        margin-top:20px;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>