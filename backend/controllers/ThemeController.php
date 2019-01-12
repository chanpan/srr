<?php

namespace backend\controllers;

use Yii;
use common\models\Slideimg;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;
use yii\web\UploadedFile;

/**
 * SlideimgController implements the CRUD actions for Slideimg model.
 */
class ThemeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                //'only' => ['index'],
                'rules' => \backend\components\Rbac::getRbac(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
	if (parent::beforeAction($action)) {
	    if (in_array($action->id, array('create', 'update'))) {
		
	    }
	    return true;
	} else {
	    return false;
	}
    }
    
    /**
     * Lists all Slideimg models.
     * @return mixed
     */
    public function actionIndex()
    {
         
        $model = \common\models\Themes::findOne('1000');
        if ($model->load(Yii::$app->request->post())) {            
            $files  = UploadedFile::getInstancesByName('name');
            if($files){
                $folderName     = \appxq\sdii\utils\SDUtility::getMillisecTime();
                $folder         = "/web/files";
                $path           = Yii::getAlias('@storage') . "{$folder}/{$folderName}"; 
                $viewPath       = Yii::getAlias('@storageUrl') . "{$folder}/{$folderName}";
                $fileName=[];
                if(\yii\helpers\BaseFileHelper::createDirectory($path,0777, true)){} //create dir
                foreach ($files as $file) {
                    $realFileName   = md5($folderName . time()). '.' . $file->extension;
                    $filePath       = "{$path}/{$realFileName}";
                     if ($file->saveAs("{$filePath}")) {
                         $fileName = ['path'=>$viewPath, 'name'=>$realFileName]; 
                     }
                } 
                $model->logo_image = \appxq\sdii\utils\SDUtility::array2String($fileName);
            }
            if($model->save()){
                return \janpan\jn\classes\JResponse::getSuccess("Success");
            }
            
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

     
}
