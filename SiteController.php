<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\components\keyStorage\FormModel;
use common\models\LoginForm;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;

/**
 * Class SiteController.
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                //'only' => ['index'],
                'rules' => [                    
                    [
                        'controllers' => ['site'],
                        'allow' => true,
                        'actions' => ['login'],
                        //'roles' => ['?'],
                    ],
                    [
                        'controllers' => ['site'],
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'fileapi-upload' => [
                'class' => FileAPIUpload::class,
                'path' => '@storage/web/images/avatars',
            ],
        ];
    } 
    public function actionTest()
    {
        //phpinfo();exit();
        //$sql  = "magick convert {$filePath} -resize 1300x450 {$target}";
        $setPath = "set PATH=%PATH%;D:\\SIWWWROOT\\simutreasure\\extensions\\imagemagick";
        //$sql="cd";
        exec($setPath, $out);
        exec("path", $out1);
        \appxq\sdii\utils\VarDumper::dump($out1);
        //return $this->render('test');
    }
    public function actionIndex()
    {
         
       $file = \common\models\Files::find()->all();
       $order = \common\models\Order::find()->all();
       $user = \common\models\User::find()->all();
       $year = date('Y');
       $view = \common\models\View::find()->where('YEAR(date) = :date', [':date'=>"{$year}"])->all();
       return $this->render('index',[
           'file'=>$file,
           'order'=>$order,
           'user'=>$user,
           'view'=>$view
       ]);
    }
    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'main-login' : 'main';

        return parent::beforeAction($action);
    }

    public function actionLogin()
    {
        
        if (!Yii::$app->user->isGuest) {            
            return $this->goHome();            
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //\appxq\sdii\utils\VarDumper::dump(Yii::$app->request->post());
            
                return $this->goHome();
             
        } else {
            $model->password = '';
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSettings()
    {
        $model = new FormModel([
            'keys' => [
                'frontend.registration' => [
                    'label' => Yii::t('backend', 'Registration'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        false => Yii::t('backend', 'Disabled'),
                        true => Yii::t('backend', 'Enabled'),
                    ],
                ],
                'frontend.email-confirm' => [
                    'label' => Yii::t('backend', 'Email confirm'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        false => Yii::t('backend', 'Disabled'),
                        true => Yii::t('backend', 'Enabled'),
                    ],
                ],
                'backend.theme-skin' => [
                    'label' => Yii::t('backend', 'Backend theme'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'skin-blue' => 'skin-blue',
                        'skin-black' => 'skin-black',
                        'skin-red' => 'skin-red',
                        'skin-yellow' => 'skin-yellow',
                        'skin-purple' => 'skin-purple',
                        'skin-green' => 'skin-green',
                        'skin-blue-light' => 'skin-blue-light',
                        'skin-black-light' => 'skin-black-light',
                        'skin-red-light' => 'skin-red-light',
                        'skin-yellow-light' => 'skin-yellow-light',
                        'skin-purple-light' => 'skin-purple-light',
                        'skin-green-light' => 'skin-green-light',
                    ],
                ],
                'backend.layout-fixed' => [
                    'label' => Yii::t('backend', 'Fixed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
                'backend.layout-boxed' => [
                    'label' => Yii::t('backend', 'Boxed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
                'backend.layout-collapsed-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
                'backend.layout-mini-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar mini'),
                    'type' => FormModel::TYPE_CHECKBOX,
                ],
            ],
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('backend', 'Settings successfully saved.'));

            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }
    public function actionImageToText(){
        $files = \common\models\Files::find()->where(['file_type'=>'2', 'description'=>''])->all();
        if($files){
            $rootPath = Yii::getAlias('@storage');
            foreach($files as $file){
                $path = "{$rootPath}/{$file->dir_path}/{$file->file_name}";
                $data = \backend\modules\sections\classes\JFiles::imageToText($path);
                $model = \common\models\Files::findOne($file->id);
                $model->description = $data;
                if($model->save()){
                    echo 'success';
                }else{
                    echo "Error => ".\yii\helpers\Json::encode($model->errors);
                }
            }
        }
    }
    public function actionTemplateAbout(){
        $model = \backend\modules\cores\classes\CoreOption::getParams('about');
        if(\Yii::$app->request->post()){
            $option_name = \Yii::$app->request->post('option_name', '');
            $option_value = \Yii::$app->request->post('option_value', '');
            $data = \backend\modules\cores\classes\CoreOption::update($option_name, $option_value); 
            if($data){
                return \janpan\jn\classes\JResponse::getSuccess("Success");
            }else{
                return \janpan\jn\classes\JResponse::getError("Error");
            }
        }
        return $this->render('template-about', ['model' => $model]);
    }
    public function actionTemplateContact(){
        $model = \backend\modules\cores\classes\CoreOption::getParams('contact');
        if(\Yii::$app->request->post()){
            $option_name = \Yii::$app->request->post('option_name', '');
            $option_value = \Yii::$app->request->post('option_value', '');
            $data = \backend\modules\cores\classes\CoreOption::update($option_name, $option_value); 
            if($data){
                return \janpan\jn\classes\JResponse::getSuccess("Success");
            }else{
                return \janpan\jn\classes\JResponse::getError("Error");
            }
        }
        return $this->render('template-contact', ['model' => $model]);
    }
    
}
