<?php if ($print == '1'): ?>
    <link rel="stylesheet" href="<?= yii\helpers\Url::to('@web/css/bootstrap.min.css') ?>"/>
    <script>
        window.print();
    </script>
<?php else: ?>
    <div class="">                   
        <button class="btn btn-primary pull-right" id="btnPrint" style="margin-top:25px;"><i class="fa fa-print"></i> <?= Yii::t('section', 'Print') ?></button>
    </div>
    <div class="clearfix"></div>
<?php endif; ?>

<?php if ($print == '1'): ?>
    <div class="container">
    <?php endif; ?>  
        <h3 class="text-center"><?= Yii::t('_app', 'Report download information of Siriraj members and members.')?> <?= $month; ?></h3>
    <table class="table table-responsive table-bordered">
        <thead>
            <tr> 
                <th>ชื่อ-สกุล</th>
                <th>จำนวนดาวน์โหลด</th>
                <th>วันที่ดาวน์โหลด</th>
                <th>ประเภทผู้ใช้</th>                
            </tr>
        </thead>
        <tbody>
            <?php $sum=0; ?>
            <?php foreach ($data as $v): ?>
                <tr>
                    <td><?= common\modules\cores\User::getProfileNameByUserId($v['user_id']) ?></td>
                    <td><?= $v['counts'] ?></td>
                    <td><?= \appxq\sdii\utils\SDdate::mysql2phpDate($v['create_at']) ?></td>
                    <td>
                        <?php
                        $sum += $v['counts'];
                        $user = [];
                        $userAssigned = Yii::$app->authManager->getAssignments($v['user_id']);
                        foreach ($userAssigned as $userAssign) {
                            $user[] = $userAssign->roleName;
                            if ($userAssign->roleName == 'administrator') {
                                echo 'Admin';
                            } else if ($userAssign->roleName == 'admin') {
                                echo 'สมาชิกศิริราช';
                            } else if ($userAssign->roleName == 'users') {
                                echo "สมาชิกทั่วไป";
                            } else {
                                echo '';
                            }
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>จำนวนดาวน์โหลดทั้งหมด</td>
                <td></td><td></td>
                <td><?= $sum; ?> รายการ</td>
            </tr>
        </tfoot>
    </table>
    <?php if ($print == '1'): ?>
    </div>
<?php endif; ?>  
<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('#btnPrint').on('click', function () {
        let year = $('#year').val();
        let month = $('#month').val();
        let params = {year: year, month: month, print: 0};

        let url = '<?= yii\helpers\Url::to(['/viewcountermanagement/view-count/report-download-preview?year='])?>' + year + '&month=' + month + '&print=1';
        window.open(url, "_blank");
        return false;
    });
</script>
<?php richardfan\widget\JSRegister::end(); ?>    