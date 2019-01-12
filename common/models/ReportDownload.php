<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report_download".
 *
 * @property int $id
 * @property int $count
 * @property int $user_id
 * @property string $create_at
 */
class ReportDownload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_download';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['id', 'count', 'user_id'], 'integer'],
            [['create_at'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('option', 'ID'),
            'count' => Yii::t('option', 'Count'),
            'user_id' => Yii::t('option', 'User ID'),
            'create_at' => Yii::t('option', 'Create At'),
        ];
    }
}
