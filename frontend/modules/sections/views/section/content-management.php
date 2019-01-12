<?php

use yii\bootstrap\Html;
use kartik\tabs\TabsX;

$this->title = Yii::t('section', $title);
if ($breadcrumb) {
    echo janpan\jn\widgets\BreadcrumbsWidget::widget([
        'breadcrumb' => $breadcrumb
    ]);
}
$modal = "modal-contents";
?>
<?php foreach ($file_type as $key => $f): ?>
    <?php if ($key > 0): ?>
        <?php
        $content_id = Yii::$app->request->get('content_id');
        $files = \common\models\Files::find()
                        ->where('content_id=:content_id AND file_type=:file_type AND rstat not in(0,3)', [':content_id' => $content_id, ':file_type' => $f['id']])
                        ->orderBy(['forder'=>SORT_ASC])
                        ->all();
            
           if($files){
               if($f['id'] == 2 || $f['id'] == 5){                    
                   echo $this->render("content-file",[
                        'f'=>$f,
                        'files'=>$files,
                        'content_id'=>$_GET['content_id'] 
                   ]);
               }else if($f['id'] == 3 || $f['id'] == 4 || $f['id'] == 6 || $f['id'] == 7 || $f['id'] == 8){
                   //if((!Yii::$app->user->isGuest) && (Yii::$app->user->can("administrator") || Yii::$app->user->can("admin"))){
                      echo $this->render("content-file",[
                            'f'=>$f,
                            'files'=>$files,
                            'content_id'=>$_GET['content_id'],
                            ''
                       ]); 
                   //}
               }
               
               
           }
        ?> 
        
    <?php endif; ?>
<?php endforeach; ?>  
