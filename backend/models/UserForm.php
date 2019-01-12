<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * Create user form.
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $roles;
    public $firstname, $lastname, $sitecode, $sap_id,$position, $sex;

    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique',
                'targetClass' => User::class,
                'filter' => function ($query) {
                    if (!$this->getModel()->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                    }
                }
            ],
            ['username', 'string', 'min' => 2, 'max' => 32],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::class,
                'filter' => function ($query) {
                    if (!$this->getModel()->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                    }
                }
            ],
            ['email', 'string', 'max' => 255],
            ['sex', 'string', 'max' => 255],
                    

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6, 'max' => 32],

            ['status', 'integer'],
            ['status', 'in', 'range' => array_keys(User::statuses())],
            ['roles', 'each',
                'rule' => ['in', 'range' => ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name')],
            ],
            [['firstname','lastname','sitecode','sap_id','position'], 'string', 'max' => 255],        
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('_user', 'Username'),
            'email' => Yii::t('_user', 'Email'),
            'password' => Yii::t('_user', 'Password'),
            'status' => Yii::t('_user', 'Status'),
            'roles' => Yii::t('_user', 'Roles'),
            
            'firstname' => Yii::t('_user', 'Firstname'),
            'lastname' => Yii::t('_user', 'Lastname'),
            'sitecode' => Yii::t('_user', 'Site Code'),
            'position' => Yii::t('_user', 'Position'),
            'sap_id' => Yii::t('_user', 'Sap_id'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->status = $model->status;
        $this->model = $model;
        $this->roles = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($model->getId()), 'name');

        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }

        return $this->model;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $isNewRecord = $model->getIsNewRecord();
            $model->username = $this->username;
            $model->email = $this->email;
            $model->status = $this->status;
            if ($this->password) {
                $model->setPassword($this->password);
            }
            $model->generateAuthKey();
            if ($model->save() && $isNewRecord) {
                $data_obj = [
                    'position'=> $this->position,
                    'firstname'=> $this->firstname, 
                    'lastname'=> $this->lastname, 
                    'sitecode'=>$this->sitecode,
                    'sap_id'=> $this->sap_id,
                    'sex'=>$this->sex    
                  ];
                $model->afterSignup($data_obj);
            }
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->getId());

            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                    $auth->assign($auth->getRole($role), $model->getId());
                }
            }

            return !$model->hasErrors();
        }

        return;
    }
}
