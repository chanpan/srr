<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\sections\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('content', 'Content Choices');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="content-choice-index">

    <div class="sdbox-header">
	<h3><?=  Html::encode($this->title) ?></h3>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'content-choice-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'content-choice-grid',
	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['content-choice/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-content-choice']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['content-choice/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-content-choice', 'disabled'=>true]),
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionContentChoiceIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

            'id',
            'content_id',
            'type',
            'label',
            'default',
            // 'forder',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{view} {update} {delete}',
	    ],
        ],
    ]); ?>
    <?php  Pjax::end();?>

</div>

<?=  ModalForm::widget([
    'id' => 'modal-content-choice',
    'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#content-choice-grid-pjax').on('click', '#modal-addbtn-content-choice', function() {
    modalContentChoice($(this).attr('data-url'));
});

$('#content-choice-grid-pjax').on('click', '#modal-delbtn-content-choice', function() {
    selectionContentChoiceGrid($(this).attr('data-url'));
});

$('#content-choice-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#content-choice-grid').yiiGridView('getSelectedRows');
	disabledContentChoiceBtn(key.length);
    },100);
});

$('#content-choice-grid-pjax').on('click', '.selectionContentChoiceIds', function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledContentChoiceBtn(key.length);
});

$('#content-choice-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalContentChoice('<?= Url::to(['content-choice/update', 'id'=>''])?>'+id);
});	

$('#content-choice-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalContentChoice(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#content-choice-grid-pjax'});
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

function disabledContentChoiceBtn(num) {
    if(num>0) {
	$('#modal-delbtn-content-choice').attr('disabled', false);
    } else {
	$('#modal-delbtn-content-choice').attr('disabled', true);
    }
}

function selectionContentChoiceGrid(url) {
        yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionContentChoiceIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#content-choice-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalContentChoice(url) {
    $('#modal-content-choice .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-content-choice').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>