<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file_type".
 *
 * @property int $id
 * @property string $name
 * @property string $create_date
 * @property int $create_by
 * @property string $update_date
 * @property int $update_by
 */
class FileType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('folder', 'ID'),
            'name' => Yii::t('folder', 'Name'),
            'create_date' => Yii::t('folder', 'Create Date'),
            'create_by' => Yii::t('folder', 'Create By'),
            'update_date' => Yii::t('folder', 'Update Date'),
            'update_by' => Yii::t('folder', 'Update By'),
        ];
    }
    public function getUser(){
        return $this->hasOne(\common\modules\user\models\User::className(), ['id'=>'create_by']);
    }
}
