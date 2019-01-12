<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_invoice".
 *
 * @property string $id
 * @property int $user_id
 * @property string $create_date
 * @property int $status 1 รอจัดส่ง  2 จัดส่งแล้ว
 * @property int $admin_id
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['user_id', 'admin_id'], 'integer'],
            [['create_date','order_id'], 'safe'],
            [['id'], 'string', 'max' => 50],
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
            'create_date' => Yii::t('order', 'Create Date'),
            'status' => Yii::t('order', '1 รอจัดส่ง  2 จัดส่งแล้ว'),
            'admin_id' => Yii::t('order', 'Admin ID'),
        ];
    }
    
    public function getShipper() {
        return $this->hasOne(Shipper::className(), ['user_id' => 'user_id']);
    }
}
