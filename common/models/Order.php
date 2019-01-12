<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $create_date
 * @property int $status 1 รอจัดส่ง  2 จัดส่งแล้ว
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             
            [['id', 'user_id', 'status'], 'integer'],
            [['create_date','admin_id','conditions', 'send_date','rstat','update_date'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('order', 'ID'),
            'user_id' => Yii::t('order', 'User ID'),
            'create_date' => Yii::t('order', 'Date'),
            'status' => Yii::t('order', '1 รอจัดส่ง  2 จัดส่งแล้ว'),
        ];
    }
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
