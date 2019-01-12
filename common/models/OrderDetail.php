<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_order_detail".
 *
 * @property int $id
 * @property int $order_id
 * @property int $produc_id
 * @property string $price
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [             
            [['id', 'order_id', 'product_id','quantity','size'], 'integer'],
            [['price'], 'number'],
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
            'order_id' => Yii::t('order', 'Order ID'),
            'product_id' => Yii::t('order', 'Product ID'),
            'price' => Yii::t('order', 'Price'),
            'quantity' => Yii::t('order', 'Quantity'),
        ];
    }
    
 
    public function getFiles() {
        return $this->hasOne(Files::className(), ['id' => 'product_id']);
    }
    public function getOrder() {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
    public function getSizes() {
        return $this->hasOne(ContentChoice::className(), ['id' => 'size']);
    }

}
