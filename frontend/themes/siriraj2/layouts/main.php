<?php

use yii\helpers\Html;

janpan\jn\assets\JScrollbarAssets::register($this);
\appxq\sdii\assets\notify\NotifyAsset::register($this);
\appxq\sdii\assets\bootbox\BootBoxAsset::register($this);

\frontend\themes\siriraj2\assets\Siriraj2Assets::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/themes/siriraj2');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?php Yii::$app->meta->displaySeo() ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        
        
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body id="page-top" class="index">
        <?php $this->beginBody() ?>

                <div class="container" id="container">

                    <?php
                    echo $this->render("header", [
                        'slide' => 1,
                        'directoryAsset' => $directoryAsset
                    ]);
                    ?>

                    <div id="mock-content">
                        <?= $content; ?>
                        <?php \appxq\sdii\widgets\CSSRegister::begin();?>
        <style>
            html , body {
                cursor: url('./images/cursro-37.png'),auto;
            }
        </style>
        <?php \appxq\sdii\widgets\CSSRegister::end();?>
                        <?php //$this->render('mock-content')?>
                    </div>
               
                </div>
                 <?php echo $this->render('footer'); ?> 
        
        
        
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

