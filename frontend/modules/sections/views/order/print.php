<?php
   $this->title= Yii::t('order','Print');
   \Yii::$app->name = "Siriraj";
   $date = isset($model->date) ? appxq\sdii\utils\SDdate::mysql2phpDate($model->date) : "";
   //$modelForm=['product'=>$product,'count'=>$count,'detail'=>$model['note'],'date'=>$model->date, 'sitecode'=>$model->sitecode, 'name'=>"{$model['firstname']} {$model['lastname']}", 'title'=>$title, 'address'=>$model->companey_name, 'tel'=>$model->tel]; 
   //$modelForm = ['product' => isset($product) ? $product : '', 'count' => isset($count) ? $count : '', 'detail' => isset($model['note']) ? $model['note'] : '', 'date' => $date, 'sitecode' => isset($model->sitecode) ? $model->sitecode : '', 'name' => "{$model['firstname']} {$model['lastname']}", 'title' => $title, 'address' => isset($model->companey_name) ? $model->companey_name : '', 'tel' => isset($model->tel) ? $model->tel : ''];
   $shipper = \common\models\Shipper::findOne($id);
   
   $firstname= isset($shipper['firstname']) ? $shipper['firstname'] : '';
   $lastname=isset($shipper['lastname']) ? $shipper['lastname'] : '';
   $fullName = "{$firstname} {$lastname}";
   $sitecode = isset($shipper['sitecode']) ? $shipper['sitecode'] : '';
   $note = isset($shipper['note']) ? $shipper['note'] : '';
   $tel = isset($shipper['tel']) ? $shipper['tel'] : '';
   $email = isset($shipper['email']) ? $shipper['email'] : '';
   $position = isset($shipper['position']) ? $shipper['position'] : '';
   //appxq\sdii\utils\VarDumper::dump($note);
   $modelForm = [
        'product' => isset($product) ? $product : '',
        'count' => isset($count) ? $count : '',
        'note' => $note,
        'date' => date('d/m/Y'),
        'sitecode' => $sitecode,
        'fname' => $firstname,
        'lname'=>$lastname,
        'name' => $fullName,
        'title' => $title,
        'address' => isset($model->companey_name) ? $model->companey_name : '',
        'tel' => $tel,
        'position'=>$position,
        'email'=>$email
    ];
   $data = \backend\modules\sections\classes\JFiles::getTemplateMark($modelForm, $template->option_value);
?>

<link href="<?= \yii\helpers\Url::to('@web/css/bootstrap.min.css')?>" rel="stylesheet" />
<div class="container" id="a4-prine">
    <?php
        echo $data;
    ?>
</div>


<?php appxq\sdii\widgets\CSSRegister::begin()?>
<style>
    body {
        background: #858589 !important;
    }
    #a4-prine{
        font-size:12pt;
        width: 210mm;
        /*border: 1px solid #333333;*/
        background: #f4f4f4;
        height: 297mm;
        padding: 27mm 16mm 27mm 16mm;
    }
    .f-t-11{
        font-size:11pt;
    }
    @media print {
        #a4-prine{
            width: null;
            border: 0;
            background: #fff;
            height: 297mm;
            padding: 27mm 16mm 27mm 16mm;
        }
    }
</style>
<?php appxq\sdii\widgets\CSSRegister::end()?>
<?php if(isset($autoPrint) && $autoPrint == true):?>
    <?php \richardfan\widget\JSRegister::begin();?>
    <script>
        window.print();
    </script>
    <?php \richardfan\widget\JSRegister::end();?>
<?php endif; ?>
