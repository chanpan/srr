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
    public function getTemplateMark($modelForm, $template) {
        
        $path = [];
        foreach ($modelForm as $key => $value) {
            $path["{" . $key . "}"] = $value;
        }
        $master = strtr($template, $path);
        return $master;
    }
    public function actionTest()
    {
        if (Yii::$app->user->can('users') || Yii::$app->user->isGuest) {
             return $this->render('not_access',[]);
        }
        //phpinfo();exit();
        //$sql  = "magick convert {$filePath} -resize 1300x450 {$target}";
        //$setPath = "set PATH=%PATH%;D:\\SIWWWROOT\\simutreasure\\extensions\\imagemagickวD:\\SIWWWROOT\\simutreasure\\extensions\\ffmpeg";
        
        //magick convert -density 800 D:\\SIWWWROOT\\simutreasure\\storage/web/files/1543552105060069300/27efdf54e0d509c1b2b32a50eb9d74a3.pdf D:\\SIWWWROOT\\simutreasure\\storage/web/files/1543552105060069300/pdf/preview.png
        $path  = Yii::getAlias('@storage');
        $filename = "{$path}/web/files/1543552105060069300/4c826ec6731adb313614ddee6917f67f_2124.png";
        $new_image = "{$path}/web/files/1543552105060069300/4c826ec6731adb313614ddee6917f67f_x.png";        
        //$sql="magick convert {$path}/web/files/1543552105060069300/27efdf54e0d509c1b2b32a50eb9d74a3.pdf {$path}/web/files/1543552105060069300/pdf/preview.png";
        $mark = \backend\models\Watermark::find()->where('type=2')->orderBy(['default'=>SORT_DESC])->all();
        foreach($mark as $k=>$m){
            $mark = "{$path}/web/{$m['path']}/{$m['name']}";
            $modelForm = [
                'filename' => ($k == 0) ? $filename : $new_image,
                'mark' => $mark,
                'target' => $new_image
            ];
            $template = self::getTemplateMark($modelForm, $m['code']);
            @exec($template, $out, $retval);
            //
        }
        \appxq\sdii\utils\VarDumper::dump($new_image);
        
        
        
//        $cmd = " -size 140x80 xc:none -fill grey -gravity NorthWest ".
//        " -draw \"text 10,10 \"SIRIRAJ MUSEUM\" \" -gravity SouthEast ".
//        " -draw \"text 500,150 \"SIRIRAJ MUSEUM\" \" miff:- | composite ".
//        " -tile - {$path}/web/files/1543552105060069300/4c826ec6731adb313614ddee6917f67f_2124.png ";
        
        $cmd="magick convert {$path}/web/files/1543552105060069300/4c826ec6731adb313614ddee6917f67f_2124.png -resize 2124x1414 -gravity Center {$mark} -composite {$new_image}
        ";
        exec("magick convert {$cmd} {$new_image}", $array);
        
        \appxq\sdii\utils\VarDumper::dump($cmd);
        
        $sql="magick convert -density 600 {$path}/web/files/1543552105060069300/27efdf54e0d509c1b2b32a50eb9d74a3.pdf -colorspace RGB -resample 300 {$path}/web/files/1543552105060069300/pdf/preview.jpg";
        echo '
        <embed src = "http://10.7.2.210/simutreasure/storage/web/files/1543552105060069300/27efdf54e0d509c1b2b32a50eb9d74a3.pdf#toolbar=0&navpanes=0&scrollbar=0" width = "500" height = "500">
        ';
        \appxq\sdii\utils\VarDumper::dump('ok');
        
        $path  = Yii::getAlias('@storage').'/web/files/1543308525075278800';
        $mark =  Yii::getAlias('@storage').'/web/images/watermark/mark_1543309426.png';
        //\appxq\sdii\utils\VarDumper::dump($path);
        //$sql="magick convert {$path}/0a6e3b7a7ce34a7efc25d41c9987e517.png -resize 1024x768 {$path}/0a6e3b7a7ce34a7efc25d41c9987e517_mark.png";
        
        //209b174b23a7f3a3ebaa2b9a8801d92d.png
        $sql = "magick convert {$path}/209b174b23a7f3a3ebaa2b9a8801d92d.png -resize 2124x1414 -gravity Center {$mark} -composite {$path}/xxx.png";
        phpinfo();
        exec("ffmpeg --version",$output);
        \appxq\sdii\utils\VarDumper::dump($output);
        //return $this->render('test');
    }
    public function actionIndex()
    {
        if (Yii::$app->user->can('users') || Yii::$app->user->isGuest) {
            return $this->render('not_access',[]);
        }
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
        if (Yii::$app->user->can('users') || Yii::$app->user->isGuest) {
            return $this->render('not_access',[]);
        }
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
