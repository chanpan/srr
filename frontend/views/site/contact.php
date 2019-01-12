<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 $this->title = Yii::t('section', 'Contact');
?>
 
<?php echo isset($contact) ? $contact : ''?>