<?php 
    $url = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
?>
<div id="mailers">
<h2>ขอแสดงความยินดี! <?= $name?> บัญชี คลังสมบัติของพิพิธภัณฑ์ศิริราช Siriraj Museum Treasure</h2>
<h3>ของคุณได้รับการลงทะเบียนเรียบร้อยแล้ว หากต้องการเปิดใช้งานบัญชีของคุณและยืนยันที่อยู่อีเมลของคุณโปรดคลิกที่ปุ่มด้านล่าง</h3>

<a style="
   background: #2196F3;
    width: 300px;
    display: block;
    text-align: center;
    padding: 10px;
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 16pt;
    margin: 0 auto;
    margin-top: 35px;
   "href="<?= $url?>/simutreasure/frontend/web/account/sign-in/confirm-email?id=<?= $user->id?>&token=<?= $user->access_token?>">ยืนยัน</a>

<p>ยืนยันอีเมลของคุณ</p>
<p>ขอขอบคุณที่ใช้งาน คลังสมบัติของพิพิธภัณฑ์ศิริราช Siriraj Museum Treasure</p>

<p>
สำหรับคำถามหรือข้อสงสัยโปรดเข้าชม Facebook fanpage ที่ https://www.facebook.com/siriraj.museum
</p>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    
    #mailers{
        background:blue;
    }
</style>
<?php appxq\sdii\widgets\CSSRegister::end();?>


