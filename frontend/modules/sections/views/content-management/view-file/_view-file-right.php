<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="col-md-4 view-file-right">
    <div class="panel panel-default">
        <div class="panel-heading"><b><?= Yii::t('section','Detail')?></b></div>
        <div class="panel-body">
            <label>
                <i class="fa fa-info-circle" aria-hidden="true"></i> <?= Yii::t('section','Note')?>
            </label>
            <div class="border-bottom">
                <div style="font-family: 'TH Sarabun New';"><?= $dataDefault['details'] ?></div>
            </div>     
            <div class="border-bottom">
                <label>
                    <i class="fa fa-calendar"></i> อัพเดตล่าสุด: <?php
                        echo isset($dataDefault['create_date']) ? appxq\sdii\utils\SDdate::mysql2phpThDateTime($dataDefault['create_date']) : '';
                        
                        ?>
                </label>    
            </div>

             
        </div>
    </div>
    
    <div class="row"> 
        <div class="col-md-12">
            <?php if (!Yii::$app->user->isGuest):  ?>
            <div class="panel panel-default" id="box">
                <div class="panel-heading"><b><?= Yii::t('section','Rules')?></b></div>
                <div class="panel-body">
                   <h4 class="text-left header-request-panel">ขอความอนุเคราะห์ภาพหรือข้อมูล โปรดปฏิบัติตามกติกา ดังนี้ </h4>
                    <div>
                        <p>1. <i class="fa fa-check-square-o"></i> คลิกเลือกภาพหรือข้อมูลที่ต้องการ เลือกลงตะกร้า</p> 
                        <p>2. ระบบจะรวบรวมข้อมูล ออกเป็นแบบฟอร์มให้ท่านกรอกคำร้องขอ</p>
                        <p>3. เมื่อเจ้าหน้าที่ได้รับอีเมล์ จะติดต่อกลับ เพื่อตกลงวิธีส่งมอบข้อมูล</p>
                    </div>
                </div>
            </div>           
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row"> 
        <div class="col-md-12">
            <?php if (!Yii::$app->user->isGuest):  ?>
            <div class="panel panel-default" id="box">                 
                <div class="panel-body">
                   <div class="text-center" style="">
                       <button style="padding:10px;font-size:16pt;" class="btn btn-success btn-lg btn-block" id="btnCart">
<img src='<?= Url::to('@web/images/cart-icon.png')?>' style='width:25px;margin-right:5px;'/><?= Yii::t('section', 'Add to cart') ?></button>
                   </div>
                    <div class="text-center" style="margin-top:10px;">
                       <button style="padding:10px;font-size:16pt;" class="btn btn-primary btn-lg btn-block" id="btnDownload"><i class="fa fa-download" aria-hidden="true"></i> <?= Yii::t('section', 'Download') ?></button>
                   </div>
                </div>
            </div>           
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row"> 
        <div class="col-md-12">
             
            <div class="panel panel-default" id="box">
                <div class="panel-heading"><?= Yii::t('section','Return to')?></div>
                <div class="panel-body">
                    <?php 
                        $fileType= \frontend\modules\sections\classes\JFiles::getTypeFile();
                    ?>
                        <div class="list-group">
                            <?php foreach ($fileType as $k => $v): ?>                            
                                    <?php if ($v['id'] != "0" && $v['id'] != "1"): ?>
                                        <?php 
                                            $files = \common\models\Files::find()->where(['file_type'=>$v['id'], 'content_id'=>Yii::$app->request->get('content_id','')])->orderBy(['id'=>SORT_ASC])->one();
                                            $fileId = isset($files) ? $files['id'] : ''; //echo $files['id'];
                                            $contentID = isset($files['content_id']) ? $files['content_id'] : Yii::$app->request->get('content_id','');
                                            $typeId = \Yii::$app->request->get('filet_id', '');
                                            //\appxq\sdii\utils\VarDumper::dump($fileType);
                                        ?>
<a href="<?= Url::to(['/sections/content-management/view-file?content_id='])?><?= $contentID?>&file_id=<?= $fileId?>&filet_id=<?= $v['id']?>" class="list-group-item <?= ($typeId == $v['id']) ? 'active' : ''?>">
                                            <h4 class="list-group-item-heading" style='    font-size: 16pt;'><i class="fa <?= "{$v['icon']}"?>"></i> <?= $v['name'] ?></h4>                                       
                                        </a>
                                    <?php endif; ?>                            
                            <?php endforeach; ?>
                        </div>        
                </div>
            </div>           
             
        </div>
    </div>
</div>

<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    
    .border-bottom{
        border-bottom: 1px solid #ecf0f5;
        border-bottom-style: dashed;
        padding-bottom: 10px;
        padding-top: 10px;
    }
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>

<?php
$modal = "modal-contents";
?>
