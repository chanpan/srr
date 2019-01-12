<?=
    GridView::widget([
        'id' => 'view-grid',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align: center;'],
                'contentOptions' => ['style' => 'width:60px;text-align: center;'],
            ],
            //'id',
            'ip',
            'view_count',
            [
                'attribute' => 'user_id',
                'label' => 'Name',
                'value' => function($model) {
                    if (!$model->user_id) {
                        return 'User';
                    }
                    $name = $model->user->userProfile->firstname . " " . $model->user->userProfile->lastname;
                    return $name;
                }
            ],
            [
                'format' => 'raw',
                'attribute' => 'create_date',
                'label' => 'Date',
                'value' => function($model) {
                    return appxq\sdii\utils\SDdate::mysql2phpDate($model->date);
                }
            ]
        ],
    ]);
    ?>