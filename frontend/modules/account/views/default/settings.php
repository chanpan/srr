<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserProfile;
use janpan\jn\widgets\FlatpickrWidget;
use vova07\fileapi\Widget as FileApi;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('user', 'Settings');
if($breadcrumb){
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);  
    }
    
  
?>
<div class="row">
    <div class="col-md-12">
 
    <div class="panel panel-default">
        <div class="panel-heading">
            <div>
                <?= Html::encode($this->title) ?> 
            </div>
        </div>
        <div class="panel-body">
             <?= $this->render("_serring",['model'=>$model, 'user'=>$user])?>
        </div>
    </div>
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
    .btn-warning{
        border: solid 1px #da7c0c;
        background: #f78d1d;
        background: -webkit-gradient(linear,left top,left bottom,from(#faa51a),to(#f47a20));
    }
    #w3-success{
        margin-top:20px;
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
    .btn-change-password{
        font-size: 1.25rem;
    }
    
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
 