<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sitecode".
 *
 * @property int $id Site id
 * @property string $name Site name
 */
class Sitecode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sitecode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sitecode', 'Site id'),
            'name' => Yii::t('sitecode', 'Site name'),
        ];
    }
}
