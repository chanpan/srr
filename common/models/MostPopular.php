<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "most_popular".
 *
 * @property int $id
 * @property int $file_id
 * @property int $count
 * @property string $date
 */
class MostPopular extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'most_popular';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'file_id', 'count'], 'integer'],
            [['date'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('section', 'ID'),
            'file_id' => Yii::t('section', 'File ID'),
            'count' => Yii::t('section', 'Count'),
            'date' => Yii::t('section', 'Date'),
        ];
    }
}
