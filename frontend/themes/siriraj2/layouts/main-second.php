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
                            'directoryAsset' => $directoryAsset,
                            'layoutSecond'=>true
                        ]);
                    ?>

                    <div id="mock-content">
                        <?= $content; ?>
                        <?php //$this->render('mock-content')?>
                    </div>
               
                </div>
                 <?php echo $this->render('footer'); ?> 
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

