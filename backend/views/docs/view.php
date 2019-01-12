<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Docs */

$this->title = 'Docs#'.$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('doc', 'Docs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docs-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?php $form = ActiveForm::begin([
            'id'=>$model->formName(),
        ]); ?>
        
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'content')->widget(
            'trntv\aceeditor\AceEditor',
            [
                'mode'=>'javascript', // programing language mode. Default "html"
                'theme'=>'xcode', // editor theme. Default "github"
                'readOnly'=>'true' // Read-only mode on/off = true/false. Default "false"
            ]
        );
            /**
             * themes
             * ambiance |  chaos | chrome | clouds | clouds_midnight | cobalt | crimson_editor |
             * dawn | dracula | dreamweaver | eclipse | github | gob | gruvbox | idle_fingers 
             * iplastic | katzenmilch | kr_theme | kuroir | merbivore | merbivore_soft | mono_industrial |
             * monokai | pastel_on_dark | solarized_dark | solarized_light | sqlserver | terminal |
             * textmate | tomorrow | tomorrow_night | tomorrow_night_blue | tomorrow_night_bright | 
             * tomorrow_night_eighties | twilight | vibrant_ink | xcode
             * 
             */
        ?>
        
        <?php ActiveForm::end(); ?> 
    </div>
</div>
