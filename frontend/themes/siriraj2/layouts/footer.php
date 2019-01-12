<div class="footer">
    <div class="container">
        <div class="pull-left">
            
            <div>พิพิธภัณฑ์ศิริราช</div>
            <div>เลขที่ 2 ถนนวังหลัง แขวงศิริราช เขตบางกอกน้อย กรุงเทพฯ 10700</div>
            <div>โทร. 024192601-2 , 2618-9</div>
            <h3>
                <b>สถิติการเข้าชม <?= \frontend\modules\sections\classes\JCounter::getView()?> ครั้ง</b>
            </h3>
        </div>
        <div class="pull-right social">
            <a href="http://www.sirirajmuseum.com" target="_blank">
                <img src='<?= yii\helpers\Url::to('@web/images/_www.png') ?>' style="width:30px"/>
            </a>&nbsp;
            <a target="_blank" href="http://www.facebook.com/siriraj.museum"><img src='<?= yii\helpers\Url::to('@web/images/_facebook.png') ?>' style="width:30px" />
            </a>
            
        </div>

    </div>
<div class='container text-center'>รองรับ Chrome  Firefox  Safari Internet explorer version 11 ขึ้นไป</div>
</div>

<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
@media screen and (max-width: 768px){
    .footer {
    padding: 10px;
    }
}

</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
