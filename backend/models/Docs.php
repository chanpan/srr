<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "docs".
 *
 * @property int $id
 * @property string $content
 * @property string $title
 * @property string $group
 */
class Docs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['content'], 'string'],
            [['title', 'group'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('doc', 'ID'),
            'content' => Yii::t('doc', 'Content'),
            'title' => Yii::t('doc', 'Title'),
            'group' => Yii::t('doc', 'Group'),
        ];
    }
}
