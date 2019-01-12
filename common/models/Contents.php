<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_contents".
 *
 * @property int $id
 * @property string $name
 * @property string $ description
 * @property int $section_id  tbl_section
 * @property int $rstat
 * @property int $public ห้อง public, private
 * @property string $content_date
 * @property string $create_date
 * @property int $user_create
 */
class Contents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_contents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','thumn_image'], 'required'],
            [['id', 'section_id', 'rstat', 'public', 'user_create','forder'], 'integer'],
            [['description'], 'string'],
            [['content_date', 'create_date','thumn_image'], 'safe'],
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
            'id' => Yii::t('section', 'ID'),
            'name' => Yii::t('section', 'Name'),
            'description' => Yii::t('section', 'Description'),
            'section_id' => Yii::t('section', ' tbl_section'),
            'rstat' => Yii::t('section', 'Rstat'),
            'public' => Yii::t('section', 'Section Public'),
            'content_date' => Yii::t('section', 'Content Date'),
            'create_date' => Yii::t('section', 'Create Date'),
            'user_create' => Yii::t('section', 'User Create'),
        ];
    }
    public function getSections()
    {
        return $this->hasOne(Sections::class, ['id' => 'section_id']);
    }
}
