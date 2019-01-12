<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "tbl_sections".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $list_content 0 ไม่มี content,  1 แสดง content ทั้งหมดในตัวมัน,   2 แสดง content ทั้งหมดใต้ตัว
 * @property int $parent_id
 * @property int $forder
 * @property int $public ห้อง public, private
 * @property int $rstat
 * @property string $icon
 */
class Sections extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'list_content', 'parent_id', 'forder', 'public', 'rstat'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'list_content' => Yii::t('app', '0 ไม่มี content,  1 แสดง content ทั้งหมดในตัวมัน,   2 แสดง content ทั้งหมดใต้ตัว'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'forder' => Yii::t('app', 'Forder'),
            'public' => Yii::t('app', 'ห้อง public, private'),
            'rstat' => Yii::t('app', 'Rstat'),
            'icon' => Yii::t('app', 'Icon'),
        ];
    }
}
