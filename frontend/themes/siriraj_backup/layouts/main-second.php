<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs; 
\frontend\assets\CustomStyleAsset::register($this);
\appxq\sdii\assets\notify\NotifyAsset::register($this);
\appxq\sdii\assets\bootbox\BootBoxAsset::register($this);
frontend\themes\siriraj\assets\SirirajAssets::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/themes/siriraj');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="page-top" class="index">
<?php $this->beginBody() ?>

<div class="wrapper">
        <div class="main-page-banner pb-50 off-white-bg home-3">
            <div class="container">
                <?= $content;?>  
            </div> 
        </div>
        <?= $this->render('footer');?> 
    </div>
 
<?= $this->render('custom_style')?>            
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>