<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
    <?=
       Breadcrumbs::widget(
         [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
         ]
     ) ?>
        
    </section>

    <section>
        <div class="container-fluid">
             <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
</footer>
 