<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\viewcountermanagement\models\ViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('section', 'Report Download');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header"></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= Yii::t('section', 'Select Year') ?></label>
<?php
$itemYear = [];
$dYear = date('Y');
for ($i = 2012; $i <= $dYear + 1; $i++) {
    $itemYear[$i] = $i + 543;
}
//\appxq\sdii\utils\VarDumper::dump($dYear);
$itemMonth = ['0' => 'all', '1' => "ม.ค.", '2' => "ก.พ.", '3' => "มี.ค.", '4' => "เม.ย.", '5' => "พ.ค.", '6' => "มิ.ย.", '7' => "ก.ค.", '8' => "ส.ค.", '9' => "ก.ย.", '10' => "ต.ค.", '11' => "พ.ย.", '12' => "ธ.ค."]
?>
                    <?= Html::dropDownList("year", date('Y'), $itemYear, ['class' => 'form-control', 'id' => 'year']) ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= Yii::t('section', 'Select Month') ?></label>
<?= Html::dropDownList("month", '', $itemMonth, ['class' => 'form-control', 'id' => 'month']) ?>
                </div> 
            </div>
            <div class="col-md-4">
                <div>                   
                    <button class="btn btn-primary btn-block" id="btnViewReport" style="margin-top:25px;"><?= Yii::t('section', 'Preview') ?></button>
                </div> 
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header"></div>
    <div class="box-body">

        <div id="preview-count"></div>

    </div>
</div>
<?php richardfan\widget\JSRegister::begin(); ?>
<script>
    $('#btnViewReport').on('click', function () {
        let year = $('#year').val();
        let month = $('#month').val();
        let params = {year: year, month: month, print: 0};
        let url = '<?= Url::to(['/viewcountermanagement/view-count/report-download-preview'])?>';
        
        
        $('#preview-count').html(`<div class='text-center'><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>`);
        $.get(url, params, function (data) {
            $('#preview-count').html(data);
        });
        return false;
    });
    function initialData(){
        let year = $('#year').val();
        let month = $('#month').val();
        let params = {year: year, month: month, print: 0};
        let url = '<?= Url::to(['/viewcountermanagement/view-count/report-download-preview'])?>';
        
        
        $('#preview-count').html(`<div class='text-center'><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>`);
        $.get(url, params, function (data) {
            $('#preview-count').html(data);
        });
        return false;
    }
    initialData();
</script>
<?php richardfan\widget\JSRegister::end(); ?>