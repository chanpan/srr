<?php 
    use yii\helpers\Html;
?>
<div class="trendig-product pb-10 off-white-bg" id="row-<?= $f['id'] ?>"> 
    <div class="container-fluid">
        <div class="trending-box">            
            <div class="product-list-box">                  

                <h3 class="text-left header-text-content" style="">
                    <i class="fa fa-<?= $f['icon'] ?>"></i> <label class="header-content-type"><?= Yii::t('section',$f['name']) ?>   </label>                    
                    <small ><?= count($files) ?> <?= Yii::t('section', 'Item') ?> </small>

                </h3>
                <div class="row" >
                    <?php foreach ($files as $key => $file): ?>
                        <div class="col-md-3 col-xs-6">
                            <?=
                            $this->render('_item_file', [
                                'model' => $file
                            ]);
                            ?>
                        </div>    
                    <?php endforeach; ?>
                    
                </div>  

                <div class="row" style="margin-top:10px;">
                        <div class="col-md-6 col-md-offset-3">
                            <?=
                                Html::a(Yii::t('section', 'more...'), yii\helpers\Url::to(['/sections/content-management/view-file?content_id='])."{$content_id}&file_id=&filet_id={$f['id']}", [
                                    'id' => "btn-{$f['id']}",
                                    'data-action' => 'view-file',
                                    'class' => 'content-popup btnCall text-center btn btn-success btn-lg btn-block',
                                    'data-id' => $f['id'],
                                    'style' => 'color:#fff;'
                                ]);
                                ?>
                        </div>
                    </div>

            </div>
            <!-- main-product-tab-area-->
        </div>
    </div>
    <!-- Container End -->
</div> 
 