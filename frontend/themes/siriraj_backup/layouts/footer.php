<?php  
    $example = \common\models\ExampleData::find()->orderBy(['forder'=>SORT_ASC])->all();
    //\appxq\sdii\utils\VarDumper::dump($section);
?>
<footer class="off-white-bg2 pt-15 bdr-top pt-sm-55">
    <!-- Footer Top Start -->
    <div class="footer-top">
        <div class="container">
            <h2 style="margin-bottom:5px;"><?= Yii::t('section','Sample information in the Knowledgebase')?></h2> 
            <!-- Signup-Newsletter End -->
            <div class="row"> 
                <?php if($example): ?>
                    <?php foreach($example as $k=>$v):?>
                        <div class="col-md-3 col-sm-6">
                            <div class="single-footer mb-sm-40">
                                <div class="footer-content">
                                    <ul class="footer-list">
                                        <li>
                                            <a target="_blank" href="<?= $v['url']?>">
                                              <?= $v['label'] ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>    
                <?php endif; ?>
                <!-- Single Footer Start -->
                
                 
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </div><br>
     
    <!-- Footer Top End -->
    <!-- Footer Middle Start -->
<!--    <div class="footer-middle text-center">
        <div class="container">
            <div class="footer-middle-content pt-20 pb-30">
                <ul class="social-footer">
                    <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                    <li>
                        <a href="#"><img src="#" alt="google play"></a>
                    </li>
                    <li>
                        <a href="#"><img src="#" alt="app store"></a>
                    </li>
                </ul>
            </div>
        </div>
         Container End 
    </div>-->
    <!-- Footer Middle End -->
    <!-- Footer Bottom Start -->
    <div class="footer-bottom pb-30">
        <div class="container">

            <div class="copyright-text text-center">
                <p>Copyright © 2018  พิพิธภัณฑ์ศิริราช All Rights Reserved.  | Website: <a href="http://www.sirirajmuseum.com" target="_blank">www.sirirajmuseum.com  </a>  &nbsp;</p>
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Footer Bottom End -->
</footer>

<?php \appxq\sdii\widgets\CSSRegister::begin();?>
            <style>
                footer.off-white-bg2.pt-95.bdr-top.pt-sm-55 { 
                    /*background: #F3D39C url(<?= "/images/open.jpg"?>) no-repeat center top;*/
                    background-size: cover;
                }
                .footer-bottom{
                    background: #641a35;
                    padding-top: 30px;
                    color:#fff;
                }
                .footer-bottom a{color:#fff;}
                    
            </style>                
<?php \appxq\sdii\widgets\CSSRegister::end();?>   