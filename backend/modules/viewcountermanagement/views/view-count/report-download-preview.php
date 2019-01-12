<?php
    use yii\helpers\Url;
    ?>
<?php if ($print == '1'): ?>
    <link rel="stylesheet" href="<?= yii\helpers\Url::to('@web/css/bootstrap.min.css') ?>"/>
    <script>
        window.print();
    </script>
<?php else: ?>
<div class="">                   
    <button class="btn btn-primary pull-right" id="btnPrint" style="margin-top:25px;"><i class="fa fa-print"></i> <?= Yii::t('section', 'Print') ?></button>
</div> 
<?php endif; ?>    
<div class="clearfix"></div>

<?php if ($print == '1'): ?>
<div class="container">
<?php endif; ?>  
   
<?php foreach ($output as $k => $month): ?>
        <div>
        <?php if ($month['data']): ?>
                <h3><?= $month['name'] ?></h3>
            <?php endif; ?>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
    <?php if ($month['data']): ?>
                        <th><?= Yii::t('_app', 'Name')?></th>
                        <th><?= Yii::t('app','Count')?></th>
                        <th><?= Yii::t('_app','Date')?></th>
                        <th><?= Yii::t('_app','User Type')?></th>
    <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
    <?php foreach ($month['data'] as $k => $v): ?>
                        <tr>
                            <td><?= common\modules\cores\User::getProfileNameByUserId($v['user_id']) ?></td>
                            <td><?= $v['counts'] ?></td>
                            <td><?= \appxq\sdii\utils\SDdate::mysql2phpDate($v['create_at']) ?></td>
                            <td>
        <?php
        //$role = \Yii::$app->authManager->getRolesByUser($v['user_id']);
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
        // \appxq\sdii\utils\VarDumper::dump($user);
        ?>
                            </td>

                        </tr>    
    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr> 
    <?php
    if (isset($month['totalAll'])) {
        echo "<td>จำนวนดาวน์โหลดทั้งหมด</td>";
        echo "<td></td><td></td>";
        echo "<td class='text-right'>{$month['totalAll']} รายการ</td>";
    }
    ?> 
                    </tr>
                </tfoot>

            </table>
        </div>
<?php endforeach; ?>
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

<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .table thead tr th{
        background: #e8e8e8;  
    }
    tfoot tr{
        background: #e8e8e866;  
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>
 
