<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user common\models\User */
//\appxq\sdii\utils\VarDumper::dump($user);
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/account/sign-in/reset-password', 'token' => $user->access_token]);
?>
<div class="password-reset">
    <p>สวัสดิ์ดีคุณ <?= Html::encode($user->username) ?>,</p>
    <p>ไปที่ลิงก์ด้านล่างเพื่อรีเซ็ตรหัสผ่าน::</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>