<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_files".
 *
 * @property int $id
 * @property string $name
 * @property string $file_type image, video , sound
 * @property string $description files
 * @property int $rstat file ใหญ่ 1000X768,
 * @property string $file_name
 * @property string $file_thumbnail ไฟล์เล็ก,
 * @property string $file_name_org file ต้นฉบับ ทุกคนไม่เห็น
 * @property string $meta_text
 * @property int $content_id
 * @property int $public public, private
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['id'], 'required'],
            [['id', 'rstat', 'content_id', 'public','user_create','forder'], 'integer'],
            [['meta_text','file_path','dir_path','file_view','description','file_thumbnail','detail_meta','details','keywords','url_origin_file','require_files'], 'string'],
            [['name', 'file_type', 'file_name', 'file_name_org'], 'string', 'max' => 255],
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
            'file_type' => Yii::t('section', 'image, video , sound'),
            'description' => Yii::t('section', 'files'),
            'rstat' => Yii::t('section', 'Rstat'),
            'file_name' => Yii::t('section', 'File Name'),
            'file_thumbnail' => Yii::t('section', 'Thumbnail,'),
            'file_name_org' => Yii::t('section', 'File Original'),
            'meta_text' => Yii::t('section', 'Meta Text'),
            'content_id' => Yii::t('section', 'Content ID'),
            'public' => Yii::t('section', 'public, private'),
            'details'=>Yii::t('section', 'Details'),
            'keywords'=>Yii::t('section', 'Keywords'),
            
        ];
    }
    
    public function getType() {
        return $this->hasOne(FileType::className(), ['id' => 'file_type']);
    }
}
