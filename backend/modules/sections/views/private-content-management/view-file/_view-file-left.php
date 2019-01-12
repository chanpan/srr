<div class="col-md-8 view-file-left">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-6 col-md-offset-3">
                    <?php 
                        if($dataDefault['file_type'] == '2'){
                            echo yii\helpers\Html::img("/images/{$dataDefault['file_name_org']}", ['class'=>'img img-responsive','style'=>"width:1024px;"]);
                        }elseif ($dataDefault['file_type'] == 3) {
                            echo"
                                <video style='width:100%' controls>
                                    <source src='/videos/{$dataDefault['file_name_org']}' type='video/mp4'>                 
                                    Your browser does not support the video tag.
                                </video>
                            ";
                        }
                    ?>
 
                </div>
            </div>
            <?=
            \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'col-md-12',
                    'id' => 'file_types',
                ],
                'itemOptions' => function($model) {
                    return ['tag' => 'div', 'data-id' => $model['id'], 'class' => 'col-md-2 col-sm-4 col-xs-6','style'=>'margin-bottom:80px;height: 80px;'];
                },
                'layout' => "{pager}\n{items}\n",
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_item', ['model' => $model]);
                },
            ]);
            ?>
            <div class="clearfix"></div>
            <?php if (!Yii::$app->user->isGuest) { ?>
                <div class="btnCart text-center" style="margin-top:50px;margin-bottom:50px;">
                    <button class="btn btn-success">เลือกลงตะกร้า</button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
     
    .view-file-left{
        border-right: 1px solid #ecf0f5;
    } 
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>