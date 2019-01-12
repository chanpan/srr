<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\LoginForm */

$this->title = Yii::t('appmenu', 'Log into your account');
$this->params['breadcrumbs'][] = $this->title;
$this->params['body-class'] = 'login-page';
?>
<div class="login-box">
    <div class="login-box-body">
        <div class="login-logo">
            <img src="<?= \yii\helpers\Url::to('@web/images/logosirirajweb.png') ?>"/>
            <h3>คลังสมบัติของพิพิธภัณฑ์ศิริราช</h3>
            <h3>Siriraj Museum Treasure</h3>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <div class="body">
            <?= $form->field($model, 'identity')->label('Username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'simple']) ?>
        </div>

        <div class="footer">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-flat btn-block btn-lg']) ?>
        </div>

        <?php ActiveForm::end() ?>
    </div>

</div>
<?php 
    $css= "
        .btn-primary{
        margin-bottom:50px;}
      .login-box, .register-box {
            width: 500px;
            margin: 7% auto;
            
        }  
        .form-control{height:45px;}
    ";
    $this->registerCss($css);
?>
