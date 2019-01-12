<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_content_choice".
 *
 * @property int $id
 * @property int $content_id
 * @property string $type
 * @property string $label
 * @property int $default
 * @property int $forder
 */
class ContentChoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_content_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'default', 'forder'], 'integer'],
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
            'content_id' => Yii::t('app', 'Content ID'),
            'type' => Yii::t('app', 'Type'),
            'label' => Yii::t('app', 'Label'),
            'default' => Yii::t('app', 'Default'),
            'forder' => Yii::t('app', 'Forder'),
        ];
    }
}
