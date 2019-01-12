<?php
    use appxq\sdii\helpers\SDNoty;
    use appxq\sdii\helpers\SDHtml;
    $this->title= Yii::t('order','คำร้อง');
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
    'title' => isset($title) ? $title : '',
    'address' => isset($model->companey_name) ? $model->companey_name : '',
    'tel' => $tel,
    'position'=>$position,
    'email'=>$email
    ];
    $data = \backend\modules\sections\classes\JFiles::getTemplateMark($modelForm, $template->option_value);
    ?>
<div class="container">
    <?php
    echo $data;
    ?>
</div>
