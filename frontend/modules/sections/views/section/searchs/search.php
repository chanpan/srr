<?php
$this->title = isset($_GET['txtsearch']) ? $_GET['txtsearch'] : Yii::t('section', 'Section');
?>
<div class="row">
    <div style="margin-top:40px;"></div>

    <div class="clearfix">
        <?= $this->render('_searchbar', ['txtsearch' => $txtsearch, 'fileType' => $fileType]); ?>
    </div>
    <div style="margin-top:20px;"></div>

    <div class="trendig-product pb-10 off-white-bg"> 
        <div class="container">
            <div class="trending-box">            
                <div class="product-list-box">                  
                    
                </div>
                <!-- main-product-tab-area-->
            </div>
        </div>
        <!-- Container End -->
    </div>


</div>
<?php appxq\sdii\widgets\CSSRegister::begin() ?>
<style>
    @media only screen and (min-width: 768px)
    {
        .cd-breadcrumb, .cd-multi-steps {
            width: 100%;
            max-width: 100%;
            margin-left: 0px;
            border: 1px solid #d2d6de;
            background:#fff;
        }
    }
    .cd-breadcrumb.custom-separator li::after, .cd-multi-steps.custom-separator li::after {
        content: '/';
        height: 22px;
        width: 1px;
        background: transparent;
        vertical-align: bottom;
    }
</style>
<?php
appxq\sdii\widgets\CSSRegister::end()?>