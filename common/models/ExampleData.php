<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "example_data".
 *
 * @property int $id
 * @property string $label
 * @property string $url
 */
class ExampleData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'example_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label', 'url'], 'string', 'max' => 255],
            [['forder'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('section', 'ID'),
            'label' => Yii::t('section', 'Label'),
            'url' => Yii::t('section', 'Url'),
        ];
    }
}
