<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_watermark".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $file_id
 * @property int $default
 */
class Watermark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_watermark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id', 'default','default_image'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255],
            [['detail','code'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('doc', 'ID'),
            'name' => Yii::t('doc', 'Name'),
            'path' => Yii::t('doc', 'Path'),
            'file_id' => Yii::t('doc', 'File ID'),
            'default' => Yii::t('doc', 'Default'),
            'code' => Yii::t('doc', 'Code'),
        ];
    }
}
