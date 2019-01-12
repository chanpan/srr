<?php 
    use yii\helpers\Html;
     
    if($model['file_type'] == '2'){
        //image
        $link  = "";        
        $link .= Html::img("{$model['file_path']}/thumbnail/{$model['file_name']}", 
                [
                    'class'=>'img img-responsive img-rounded',
                    'style'=>'width:100px;height: 80px;'
                ]);
        $link .= "<div>{$model['file_name_org']}</div>";
    }else if($model['file_type'] == '3'){
        //video
        $link = "";
        $link .= "
            <video style='width:100%;height: 100px;'>
                <source src='/videos/{$model['file_name_org']}' type='video/mp4'>                 
                Your browser does not support the video tag.
            </video>
        ";
        $link .= "<div>{$model['name']}</div>";
    }else if($model['file_type'] == '4'){
        //audio
        $link = "";
        $link .= "
            
            <audio controls style='width:100%;height: 100px;'>
                <source src='/audio/{$model['file_name_org']}' type='audio/mpeg'>                 
                Your browser does not support the video tag.
            </audio>
        ";
        $link .= "<div>{$model['name']}</div>";        
    }else if($model['file_type'] == '5'){
        //docx or pdf
        $link= " 
            <div><i class='fa fa-file'></i> {$model['file_name_org']}</div>
        ";   
    }
    $taga = "";
    $taga .= "<div style='margin-bottom:10px;text-align:center;'>";            
            $taga .= Html::button("<i class='fa fa-trash'></i>", [
                 'data-id' => $model['id'],
                'data-action' => 'delete',
                'class' => 'btn btn-danger btn-xs btnDelete',
                'title' => Yii::t('appmenu', 'Delete'),
                'data-url' => yii\helpers\Url::to(['/sections/file-management/delete-file']),
                'data-method' => 'POST'
            ]);
        $taga .= "</div>";
    $taga .=  Html::a($link, yii\helpers\Url::to(['/sections/content-management/view-file?content_id='])."{$_GET['content_id']}&file_id={$model['id']}&filet_id={$model['file_type']}" ,
    [
        'id'=>"btn-{$model['id']}",
        'data-action'=>'view-file',
        'class'=>'content-popup btnCall',
        'data-id'=>$model['id'],
    ]);
    echo $taga;
?> 
<?php $this->registerCss("a{color:#000;}")?>
