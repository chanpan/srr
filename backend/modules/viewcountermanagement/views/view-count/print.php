<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

//\appxq\sdii\utils\VarDumper::dump($labels);
?>
<link rel="stylesheet" href="<?= Url::to('@web/css/bootstrap.min.css') ?>"/>

<div class="">
    <?php if($print == 0):?>
    <button class="btn btn-success btnPrint pull-right"><i class="glyphicon glyphicon-print"></i> <?= Yii::t('view','Print')?></button>
    <?php else:?>
        <?php                    richardfan\widget\JSRegister::begin();?>
        <script>
             setTimeout(function(){
                 window.print();
             },1000);
        </script>
        <?php                    richardfan\widget\JSRegister::end();?>    
    <?php endif; ?>    
        <h3 class="text-center"><?= Yii::t('section','Website Traffic Statistics')?></h3>
    <?=
    \dosamigos\chartjs\ChartJs::widget([
        'type' => 'bar',
        'options' => [
            'height' => 200,
            'width' => 600,
            'id' => 'xxx'
        ],
        'data' => [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => Yii::t('section','Website Traffic Statistics'),
                    'data' => $datas,
                    'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
                        'rgba(190, 124, 145, 0.8)',
                        '#FF9A9A',
                        '#FF9A9A',
                        '#FF9A9A',
                        '#FF9A9A',
                        '#FF9A9A',
                        '#FF9A9A',
                        '#FF9A9A',
                        '#FF9A9A',
                        '#FF9A9A',
                    ],
                    'borderColor' => [
                        '#fff',
                        '#fff',
                        '#fff'
                    ],
                    'borderWidth' => 1,
                    'hoverBorderColor' => ["#999", "#999", "#999"],
                ]
            ]
        ]
    ]);
    ?>
    <?= $output?>
</div>


<?php                    richardfan\widget\JSRegister::begin();?>
<script>
    $('.btnPrint').on('click',function(){
       let year = $('#year').val();
       let month = $('#month').val();
       let params = {year:year, month:month, print:0};
       let url = '<?= Url::to(['/viewcountermanagement/view-count/preview?year='])?>'+year+'&month='+month+'&print=1';
       window.open(url, "target=_blank")
       return false;
    });
</script>
<?php                    richardfan\widget\JSRegister::end();?>