<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "templates".
 *
 * @property int $id
 * @property string $type
 * @property string $label
 * @property int $default
 * @property int $forder
 */
class Templates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['default', 'forder'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'label' => Yii::t('app', 'Label'),
            'default' => Yii::t('app', 'Default'),
            'forder' => Yii::t('app', 'Forder'),
        ];
    }
}
