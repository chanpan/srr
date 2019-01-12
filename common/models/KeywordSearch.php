<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "keyword_search".
 *
 * @property int $id
 * @property string $word
 * @property string $status
 * @property string $date
 */
class KeywordSearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keyword_search';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['status'], 'integer'],
            [['date'], 'safe'],
            [['word'], 'string', 'max' => 255],
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
            'word' => Yii::t('section', 'Word'),
            'status' => Yii::t('section', 'Status'),
            'date' => Yii::t('section', 'Date'),
        ];
    }
}
