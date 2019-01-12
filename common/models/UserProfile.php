<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use vova07\fileapi\behaviors\UploadBehavior;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property integer $birthday
 * @property string $avatar_path
 * @property integer $gender
 * @property string $website
 * @property string $other
 */
class UserProfile extends ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'avatar_path' => [
                        'path' => '@storage/web/images/avatars',
                        'tempPath' => '@storage/web/tmp',
                        'url' => Yii::getAlias('@storageUrl/web/images/avatars'),
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['birthday', 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            ['gender', 'in', 'range' => [null, self::GENDER_MALE, self::GENDER_FEMALE]],
            ['website', 'trim'],
            ['website', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']],
            ['other', 'string', 'max' => 1024],
            [['firstname', 'lastname', 'avatar_path', 'website'], 'string', 'max' => 255],
           // ['firstname', 'match', 'pattern' => '/^[a-zа-яё]+$/iu'],
           // ['lastname', 'match', 'pattern' => '/^[a-zа-яё]+(-[a-zа-яё]+)?$/iu'],
            ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['firstname', 'lastname', 'birthday', 'gender', 'website', 'other'], 'default', 'value' => null],
            [['image','birthday','sitecode','sap_id','position','approval'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstname' => Yii::t('_user', 'Firstname'),
            'lastname' => Yii::t('_user', 'Lastname'),
            'birthday' => Yii::t('_user', 'Birthday'),
            'avatar_path' => Yii::t('_user', 'Avatar'),
            'gender' => Yii::t('_user', 'Gender'),
            'website' => Yii::t('_user', 'Website'),
            'other' => Yii::t('_user', 'Other'),
            'Save Icon'=>Yii::t('_user', 'Save Icon'),
            'position' => Yii::t('_user', 'Position'),
            'approval'=> Yii::t('_user', 'Position'),
             
        ];
    }
}
