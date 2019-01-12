<?php
use yii\helpers\Html;
$this->title = Yii::t('cart', 'Shipping address');

if($breadcrumb){
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);  
    }
?>

<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title)?></div>
    <div class="panel-body">
        <div class="col-md-6 col-md-offset-3">
            <div style="color:red;">*<?= Yii::t('cart','Please fill in all information.')?></div>
        </div>
        <?php
            echo $this->render('_form',['model'=>$model]);
        ?>
    </div>
</div>
<?php \appxq\sdii\widgets\CSSRegister::begin()?>
<style>
    @media only screen and (min-width: 768px){
        .cd-breadcrumb, .cd-multi-steps {     
            max-width: 100%;    
            margin-left: 0; 
        }
    }
    .form-control{
        font-size: 1.5rem;
    }
    .dropdown-menu{
        font-size: 1.5rem;
    }
    .input-group-addon{
        padding: 8px 60px;
    }
    .btn-group-lg>.btn, .btn-lg {
        padding: .5rem 1rem;
        font-size: 2.25rem;
        line-height: 1.5;
        border-radius: .3rem;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>