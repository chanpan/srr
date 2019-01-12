<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use backend\widgets\TinyMCECallback;
use dosamigos\tinymce\TinyMce;
use dominus77\iconpicker\IconPicker;

/* @var $this yii\web\View */
/* @var $model common\models\Sections */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div>

    <?php
    $form = ActiveForm::begin([
                'id' => $model->formName(),
    ]);
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><b>&times;</b></button>
        <h4 class="modal-title" id="itemModalLabel"><b>Sections</b></h4>
    </div>

    <div class="modal-body">
        <div class="row"> 

            <div class="col-md-8">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> 
            </div>
            <div class="col-md-4">
                <?=
                $form->field($model, 'icon')->widget(IconPicker::className(), [
                    'options' => ['id' => 'icon-picker', 'class' => 'form-control'],
                    'clientOptions' => [
                        'title' => 'Font Awesome Icon', // Popover title (optional) only if specified in the template
                        'selected' => false, // use this value as the current item and ignore the original
                        'defaultValue' => false, // use this value as the current item if input or element value is empty
                        'placement' => 'bottom', // (has some issues with auto and CSS). auto, top, bottom, left, right
                        'collision' => 'none', // If true, the popover will be repositioned to another position when collapses with the window borders
                        'animation' => true, // fade in/out on show/hide ?
                        //hide iconpicker automatically when a value is picked. it is ignored if mustAccept is not false and the accept button is visible
                        'hideOnSelect' => false,
                        'showFooter' => false,
                        'searchInFooter' => false, // If true, the search will be added to the footer instead of the title'
                        'mustAccept' => false, // only applicable when there's an iconpicker-btn-accept button in the popover footer
                        'selectedCustomClass' => 'bg-primary', // Appends this class when to the selected item
                        //'icons' => [], // list of icon classes (declared at the bottom of this script for maintainability)
                        'fullClassFormatter' => new \yii\web\JsExpression("function(val){return 'fa ' + val;}"),
                        'input' => 'input,.iconpicker-input', // children input selector
                        'inputSearch' => false, // use the input as a search box too?
                        'container' => false, //  Appends the popover to a specific element. If not set, the selected element or element parent is used
                        'component' => '.input-group-addon,.iconpicker-component', // children component jQuery selector or object, relative to the container element
                        // Plugin templates:
                        'templates' => [
                            'popover' => '<div class="iconpicker-popover popover"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
                            'footer' => '<div class="popover-footer"></div>',
                            'buttons' => '<button class="iconpicker-btn iconpicker-btn-cancel btn btn-default btn-sm">Cancel</button> <button class="iconpicker-btn iconpicker-btn-accept btn btn-primary btn-sm">Accept</button>',
                            'search' => '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" />',
                            'iconpicker' => '<div class="iconpicker"><div class="iconpicker-items"></div></div>',
                            'iconpickerItem' => '<a role="button" href="#" class="iconpicker-item"><i></i></a>',
                        ],
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-8">
                <?php
                $parent_list = \yii\helpers\ArrayHelper::map($parent_section, 'id', 'name');
                echo $form->field($model, 'parent_id')->dropDownList($parent_list, ['prompt' => Yii::t('section', 'Select Section')]);
                ?>
            </div>
            <div class="col-md-4">
                <?php
                $model->public = ($model->public != '') ? $model->public : 1;
                echo $form->field($model, 'public')->inline()->radioList(['1' => Yii::t('section', 'Pulbic'), '2' => Yii::t('section', 'Private')])
                ?>
            </div>


            <div class="col-md-12">
                <?=
                $form->field($model, 'content')->widget(TinyMce::class, [
                    'language' => strtolower(substr(Yii::$app->language, 0, 2)),
                    'options' => ['id' => 'tests'],
                    'clientOptions' => [
                        'height' => 350,
                        'plugins' => [
                            'advlist autolink lists link image charmap print preview anchor pagebreak',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table contextmenu paste code textcolor colorpicker',
                        ],
                        'toolbar' => 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor',
                        'file_picker_callback' => TinyMCECallback::getFilePickerCallback(['/file-manager/frame']),
                    ],
                ])
                ?>



            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton("Submit", ['class'=>'btn btn-primary btn-block btn-lg'])?>
                <?php // Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-block btn-lg' : 'btn btn-primary btn-block btn-lg']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>

<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
    $('#modal-contents').bind('hidden.bs.modal', function () {
        if (window.tinyMCE !== undefined && tinyMCE.editors.length) {
            for (e in tinyMCE.editors) {
                tinyMCE.editors[e].destroy();
            }
        }
    });
// JS script
    $('form#<?= $model->formName() ?>').on('beforeSubmit', function (e) {
        var $form = $(this);
        $.post(
                $form.attr('action'), //serialize Yii2 form
                $form.serialize()
                ).done(function (result) {
            if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                $(document).find('#modal-contents').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 1000);
                if (result.action == 'create') {
                    //$(\$form).trigger('reset');
                    $(document).find('#modal-sections').modal('hide');
                    $.pjax.reload({container: '#sections-grid-pjax'});
                } else if (result.action == 'update') {
                    $(document).find('#modal-sections').modal('hide');
                    $.pjax.reload({container: '#sections-grid-pjax'});
                }

            } else {
<?= SDNoty::show('result.message', 'result.status') ?>
            }
        }).fail(function () {
<?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"') ?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>