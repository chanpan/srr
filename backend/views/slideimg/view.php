<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Slideimg */

$this->title = 'Slideimg#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('section', 'Slideimgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slideimg-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'name',
		'detail:ntext',
		'file_path:ntext',
	    ],
	]) ?>
    </div>
</div>
