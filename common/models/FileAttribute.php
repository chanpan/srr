<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_fileattribute".
 *
 * @property int $id
 * @property string $name
 */
class FileAttribute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_fileattribute';
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
            'id' => Yii::t('knowledges', 'ID'),
            'name' => Yii::t('knowledges', 'Name'),
        ];
    }
}
