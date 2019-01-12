<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_view".
 *
 * @property int $id
 * @property string $ip
 * @property int $view_count
 * @property string $date
 * @property int $user_id
 */
class View extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['view_count', 'user_id'], 'integer'],
            [['date'], 'safe'],
            [['ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Ip'),
            'view_count' => Yii::t('app', 'View Count'),
            'date' => Yii::t('app', 'Date'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
