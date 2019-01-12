 <?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sections */

$this->title = Yii::t('section', 'Update {modelClass}: ', [
    'modelClass' => 'Sections',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('section', 'Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sections-update">

    <?= $this->render('_form', [
        'parent_section'=>$parent_section,
        'model' => $model,
    ]) ?>

</div>