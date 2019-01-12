<?php

use yii\helpers\Html;

    $this->title = Yii::t('order', "Send Email");
    \Yii::$app->name = "Siriraj";
    $date = isset($model->date) ? appxq\sdii\utils\SDdate::mysql2phpDate($model->date) : "";
    
    $fullName = Yii::$app->user->identity->userProfile->firstname .' '.Yii::$app->user->identity->userProfile->lastname;
    $sitecode = isset(Yii::$app->user->identity->userProfile->sitecode) ? Yii::$app->user->identity->userProfile->sitecode : '';
    $modelForm = [
         'product' => isset($product) ? $product : '',
         'count' => isset($count) ? $count : '',
         'detail' => isset($model['note']) ? $model['note'] : '',
         'date' => date('d/m/Y'),
         'sitecode' => $sitecode,
         'name' => $fullName,
         'title' => $title,
         'address' => isset($model->companey_name) ? $model->companey_name : '',
         'tel' => isset($model->tel) ? $model->tel : ''
     ];
    
    //$modelForm = ['product' => isset($product) ? $product : '', 'count' => isset($count) ? $count : '', 'detail' => isset($model['note']) ? $model['note'] : '', 'date' => $date, 'sitecode' => isset($model->sitecode) ? $model->sitecode : '', 'name' => "{$model['firstname']} {$model['lastname']}", 'title' => $title, 'address' => isset($model->companey_name) ? $model->companey_name : '', 'tel' => isset($model->tel) ? $model->tel : ''];
    $data = \backend\modules\sections\classes\JFiles::getTemplateMark($modelForm, $template->option_value);
    $email_default = \backend\modules\cores\classes\CoreOption::getParams('email_request');
?>
<br>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <i class="fa fa-envelope"></i> <?= Html::encode($this->title) ?>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-sm btn-info" target="_BLANK" href="/sections/order/print?id==<?= Yii::$app->request->get('id')?>&type=preview"><i class="fa fa-eye"></i> <?= Yii::t('section','Preview Form')?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?php 
                    if($email){
                        echo "<div class='alert alert-info'>ส่ง email {$email} เรียบร้อย รออนุมมัติจากพิพิธภัณฑ์</div>";
                    }
                ?>
                <div class="form-group">
                    <label><?= Yii::t('order', 'Email')?> : </label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $email_default['option_value'] ?>"/>
                </div>
                <div>
                    <a href="#" class="btn btn-block btn-success btnSendMail btn-lg"><?= Yii::t('order', 'Send') ?></a>
                </div>
                <?php
                if($email){
                    
                    \Yii::$app->mailer->compose()
                    ->setFrom(['ncrc.damasac@gmail.com' => 'พิพิธภัณฑ์ศิริราช'])
                    ->setTo($email)
                    ->setSubject('แบบฟอร์มและหนังสือขอภาพพิพิธภัณฑ์ศิริราช') 
                    ->attach($fileName)     
                    ->setHtmlBody('แบบฟอร์มและหนังสือขอภาพพิพิธภัณฑ์ศิริราช') //เลือกอยางใดอย่างหนึ่ง
                    ->send();
                    exec("rm -rf {$fileName}");
                }
                 
                ?>
            </div>
        </div>  
    </div>
</div>

<?php \richardfan\widget\JSRegister::begin();?>
<script>
     $('.btnSendMail').on('click', function(){
       let email = $('#email').val();  
       let url = '<?= yii\helpers\Url::to(['/sections/order/print?id='])?><?= $_GET['id']?>&type=mail&email='+email;  
       location.href = url;
       return false; 
    }); 
</script>
<?php \richardfan\widget\JSRegister::end();?>
<?php \appxq\sdii\widgets\CSSRegister::begin()?>
<style>
    .form-control{
         font-size: 1.25rem;
    }
    .btn-group-lg>.btn, .btn-lg {
        padding: .5rem 1rem;
        font-size: 20pt;
        line-height: 1.5;
        border-radius: .3rem;
    }
    .btn-sm, .btn-group-sm > .btn {
        padding: 5px 10px;
        font-size: 16px;
        line-height: 1.5;
        border-radius: 3px;
    }
    .btn-success:active:hover, .btn-success.active:hover, .open > .dropdown-toggle.btn-success:hover, .btn-success:active:focus, .btn-success.active:focus, .open > .dropdown-toggle.btn-success:focus, .btn-success:active.focus, .btn-success.active.focus, .open > .dropdown-toggle.btn-success.focus {
        color: #fff;
        background-color: #57a19f;
        border-color: #509694;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>