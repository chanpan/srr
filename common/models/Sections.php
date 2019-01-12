<?php

namespace common\models;

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
            [['name'], 'required'],
            [['id', 'list_content', 'parent_id', 'forder', 'public', 'rstat'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['icon','detail'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('section', 'ID'),
            'name' => Yii::t('section', 'Section Name'),
            'content' => Yii::t('section', 'Content'),
            'list_content' => Yii::t('section', '0 ไม่มี content,  1 แสดง content ทั้งหมดในตัวมัน,   2 แสดง content ทั้งหมดใต้ตัว'),
            'parent_id' => Yii::t('section', 'Parent'),
            'forder' => Yii::t('section', 'Forder'),
            'public' => Yii::t('section', 'Section Public'),
            'rstat' => Yii::t('section', 'Rstat'),
            'icon'=>Yii::t('section', 'Icon'),
            'content'=>Yii::t('section', 'Content'),
            'detail'=>Yii::t('section', 'Detail'),
        ];
    }
}
