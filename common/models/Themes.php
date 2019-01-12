<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "themes".
 *
 * @property int $id
 * @property string $bg_header
 * @property string $bg_menu
 * @property string $bg_border_menu
 * @property string $bg_menu_link
 * @property string $bg_menu_link_hover
 * @property string $bg_footer
 * @property string $bg_footer_txt
 */
class Themes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'themes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logo_image'], 'string'],
            [['color_logo_text','bg_header', 'bg_menu', 'bg_border_menu', 'bg_menu_link', 'bg_menu_link_hover', 'bg_footer', 'bg_footer_txt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('section', 'ID'),
            'bg_header' => Yii::t('section', 'Background Header'),
            'bg_menu' => Yii::t('section', 'Background Menu'),
            'bg_border_menu' => Yii::t('section', 'Border Menu'),
            'bg_menu_link' => Yii::t('section', 'Color Menu Link'),
            'bg_menu_link_hover' => Yii::t('section', 'Color Menu Link Hover'),
            'bg_footer' => Yii::t('section', 'Background Footer'),
            'bg_footer_txt' => Yii::t('section', 'Color Footer Txt'),
            'color_logo_text' => Yii::t('section', 'Color Logo Text'),
            'logo_image' => Yii::t('section', 'Logo Image'),
        ];
    }
}
