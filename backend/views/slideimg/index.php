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

$this->title = Yii::t('section', 'Slider Image');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="panel panel-primary">

    <div class="panel-heading">
	 <?=  Html::encode($this->title) ?>
    </div>

    <div class="panel-body">
        <?php  Pjax::begin(['id'=>'slideimg-grid-pjax']);?>
    <?=        GridView::widget([
	'id' => 'slideimg-grid',
	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['slideimg/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-slideimg']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['slideimg/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-slideimg', 'disabled'=>true]),
	'dataProvider' => $dataProvider,
	'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionSlideimgIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

            //'id',
            [
              'attribute'=>'name',
              'format'=>'raw',
              'value'=>function($model){
              $path = \Yii::getAlias('@storageUrl');
                $src = "{$path}/images/watermark/{$model['name']}";
                return Html::img($src, ['class'=>'img img-responsive', 'style'=>'width:100px;']);
              }
            ],
            'forder',         
            'detail:ntext',
            //'file_path:ntext',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{update} {delete}',
	    ],
        ],
    ]); ?>
    <?php  Pjax::end();?>
    </div>

</div>

<?=  ModalForm::widget([
    'id' => 'modal-slideimg',
    'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#slideimg-grid-pjax').on('click', '#modal-addbtn-slideimg', function() {
    modalSlideimg($(this).attr('data-url'));
});

$('#slideimg-grid-pjax').on('click', '#modal-delbtn-slideimg', function() {
    selectionSlideimgGrid($(this).attr('data-url'));
});


$('#slideimg-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#slideimg-grid').yiiGridView('getSelectedRows');
	disabledSlideimgBtn(key.length);
    },100);
});

$('#slideimg-grid-pjax').on('click', '.selectionSlideimgIds', function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledSlideimgBtn(key.length);
});

$('#slideimg-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalSlideimg('<?= Url::to(['slideimg/update', 'id'=>''])?>'+id);
});	

$('.grid-view').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalSlideimg(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    setTimeout(function(){
                        location.reload();
                    },1000);
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

function disabledSlideimgBtn(num) {
    if(num>0) {
	$('#modal-delbtn-slideimg').attr('disabled', false);
    } else {
	$('#modal-delbtn-slideimg').attr('disabled', true);
    }
}

function modalSlideimgselectionSlideimgGrid(url) {
    yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionSlideimgIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    setTimeout(function(){
                        location.reload();
                    },1000);
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}
$('#modal-addbtn-slideimg').on('click', function() {
    modalSlideimg($(this).attr('data-url'));
});

function modalSlideimg(url) {
    $('#modal-slideimg .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-slideimg').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>