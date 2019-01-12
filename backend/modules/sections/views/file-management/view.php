<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ContentChoice */

$this->title = 'Content Choice#'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Content Choices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-choice-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'content_id',
		'type',
		'label',
		'default',
		'forder',
	    ],
	]) ?>
    </div>
</div>
