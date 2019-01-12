<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_options".
 *
 * @property int $id
 * @property string $option_name
 * @property string $option_value
 * @property string $option_label
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_value'], 'string'],
            [['option_name', 'option_label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('option', 'ID'),
            'option_name' => Yii::t('option', 'Option Name'),
            'option_value' => Yii::t('option', 'Option Value'),
            'option_label' => Yii::t('option', 'Option Label'),
        ];
    }
}
