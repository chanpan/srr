<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\View */

$this->title = 'View#'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Views'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'ip',
		'view_count',
		'date',
		'user_id',
	    ],
	]) ?>
    </div>
</div>
