<?php

namespace frontend\modules\account\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $verifyCode;
    public $firstname;
    public $lastname;
    public $sitecode;
    public $sap_id;
    public $position;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => User::class],
            ['username', 'string', 'min' => 2, 'max' => 32],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 32],

            ['password_confirm', 'required'],
            ['password_confirm', 'string', 'min' => 6, 'max' => 32],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
            
            
            [['firstname','lastname'], 'required'],
            [['firstname','lastname','sitecode'], 'string', 'max' => 100],
            [['sap_id','sitecode','position'], 'safe'],

            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'password_confirm' => Yii::t('user', 'Confirm password'),
            'verifyCode' => Yii::t('user', 'Verification code'),
            'sitecode'=>Yii::t('user', 'Sitecode'),
            'firstname'=>Yii::t('user', 'Firstname'),
            'lastname'=>Yii::t('user', 'Lastname'),
            'sap_id'=> Yii::t('user','SAP ID'),
            'position'=>Yii::t('user', 'Position'),
            
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = Yii::$app->keyStorage->get('frontend.email-confirm') ? User::STATUS_INACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            $data_obj = ['position'=> $this->position,'firstname'=> $this->firstname, 'lastname'=> $this->lastname, 'sitecode'=>$this->sitecode, 'sap_id'=> $this->sap_id];
            $user->afterSignup($data_obj);

            return $user;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_INACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            $user->generateAccessToken();
        } else {
            return false;
        }

        if (!$user->save()) {
            return false;
        }
        
        return Yii::$app->mailer->compose('activation', ['user' => $user, 'name'=>"{$this->firstname} {$this->lastname}"])
            ->setFrom(['chanpandamasac@gmail.com' => 'Siriraj Museum Treasure'])
            ->setTo($this->email)
            ->setSubject(Yii::t('frontend', "{$this->firstname} {$this->lastname} ยืนยันที่อยู่อีเมลของคุณ | คลังสมบัติของพิพิธภัณฑ์ศิริราช Siriraj Museum Treasure", ['name' => Yii::$app->name]))
            ->send();
    //\appxq\sdii\utils\VarDumper::dump($user->access_token);
    }
}
