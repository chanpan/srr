<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('_app', 'Example Data');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">

    <div class="box-header">
	 <?=  Html::encode($this->title) ?> 
    </div>

    <div class="box-body">
        <?php  Pjax::begin(['id'=>'example-data-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'example-data-grid',
	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['example-data/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-example-data']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['example-data/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-example-data', 'disabled'=>true]),
	'dataProvider' => $dataProvider,
	'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionExampleDatumIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

             
            'label',
            'url:url',
            'forder',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{view} {update} {delete}',
	    ],
        ],
    ]); ?>
    <?php  Pjax::end();?>
    </div>

</div>

<?=  ModalForm::widget([
    'id' => 'modal-example-data',
    'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#example-data-grid-pjax').on('click', '#modal-addbtn-example-data', function() {
    modalExampleDatum($(this).attr('data-url'));
});

$('#example-data-grid-pjax').on('click', '#modal-delbtn-example-data', function() {
    selectionExampleDatumGrid($(this).attr('data-url'));
});

$('#example-data-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#example-data-grid').yiiGridView('getSelectedRows');
	disabledExampleDatumBtn(key.length);
    },100);
});

$('#example-data-grid-pjax').on('click', '.selectionExampleDatumIds', function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledExampleDatumBtn(key.length);
});

$('#example-data-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalExampleDatum('<?= Url::to(['example-data/update', 'id'=>''])?>'+id);
});	

$('#example-data-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalExampleDatum(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#example-data-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }).fail(function() {
		<?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
		console.log('server error');
	    });
	});
    }
    return false;
});

function disabledExampleDatumBtn(num) {
    if(num>0) {
	$('#modal-delbtn-example-data').attr('disabled', false);
    } else {
	$('#modal-delbtn-example-data').attr('disabled', true);
    }
}

function selectionExampleDatumGrid(url) {
    yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionExampleDatumIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#example-data-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalExampleDatum(url) {
    $('#modal-example-data .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-example-data').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>