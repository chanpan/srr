<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
if($breadcrumb){
        echo janpan\jn\widgets\BreadcrumbsWidget::widget([
            'breadcrumb'=>$breadcrumb
        ]);  
    }
?>

<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <p>
            <?php if ($profile->avatar_path) : ?>
                <img src="<?= Yii::getAlias('@storageUrl/avatars/' . $profile->avatar_path) ?>" class="img-thumbnail" alt>
            <?php else: ?>
                <img src="<?= Yii::$app->homeUrl . '/static/img/default.png' ?>" class="img-thumbnail" alt>
            <?php endif ?>
        </p>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => Yii::t('frontend', 'Firstname'),
                    'value' => $profile->firstname,
                    'visible' => $profile->firstname !== null,
                ],
                [
                    'attribute' => Yii::t('frontend', 'Lastname'),
                    'value' => $profile->lastname,
                    'visible' => $profile->lastname !== null,
                ],
                [
                    'attribute' => Yii::t('frontend', 'Birthday'),
                    'format' => 'date',
                    'value' => $profile->birthday,
                    'visible' => $profile->birthday !== null,
                ],
                [
                    'attribute' => Yii::t('frontend', 'Gender'),
                    'value' => $profile->gender == UserProfile::GENDER_MALE ? Yii::t('frontend', 'Male') : Yii::t('frontend', 'Female'),
                    'visible' => $profile->gender !== null,
                ],
                [
                    'attribute' => Yii::t('frontend', 'Website'),
                    'format' => 'raw',
                    'value' => Html::a($profile->website, $profile->website, ['target' => '_blank']),
                    'visible' => $profile->website !== null,
                ],
                [
                    'attribute' => Yii::t('frontend', 'Other'),
                    'value' => $profile->other,
                    'visible' => $profile->other !== null,
                ],
                'created_at:datetime',
                'action_at:datetime',
            ],
        ])
        ?>

        <p>
            <?php
            if ($model->id !== Yii::$app->user->id) {
                echo Html::a(Yii::t('frontend', 'Send email'), ['message', 'id' => $model->id], ['class' => 'btn btn-success']);
            }
            ?>
        </p>
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
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>