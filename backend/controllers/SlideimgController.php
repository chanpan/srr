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

/**
 * SlideimgController implements the CRUD actions for Slideimg model.
 */
class SlideimgController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Slideimg::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slideimg model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    return $this->renderAjax('view', [
		'model' => $this->findModel($id),
	    ]);
	} else {
	    return $this->render('view', [
		'model' => $this->findModel($id),
	    ]);
	}
    }

    /**
     * Creates a new Slideimg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new Slideimg();

	    if ($model->load(Yii::$app->request->post())) {
		 $files = \yii\web\UploadedFile::getInstancesByName('file');
                 $post = \Yii::$app->request->post('Slideimg', '');
                 if($files){
                     $pathDefault = "/web/images/watermark";
                     $path   = Yii::getAlias('@storage') . $pathDefault;
                     $f = $files[0];
                     $genName    = time();
                     $fileName   = md5($genName).".".$f->extension;
                     $filePath   = "{$path}/{$fileName}";
                     $viewPath   = Yii::getAlias('@storageUrl') . "/images/watermark"; 
                     $target     = "{$path}/mark_".$genName.".jpg";
                     if ($f->saveAs($filePath)) {
                          //$sql  = "magick convert {$filePath} -resize 1300x450 {$target}";
                            //exec($sql, $out, $retval);
                            //@unlink($filePath);
                         //$model->name = "mark_".$genName.".jpg";
                         $model->name = $fileName;
                         $model->file_path = $path;
                         $model->view_path = $viewPath;
                         $model->detail = $post['detail'];
                         if($model->save()){
                             return \janpan\jn\classes\JResponse::getSuccess("Success");
                         }else{
                             return \janpan\jn\classes\JResponse::getError(\yii\helpers\Json::encode($model->errors));
                         }
                     }
                 }
	    } else {
		return $this->renderAjax('create', [
		    'model' => $model,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Updates an existing Slideimg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);

	    if ($model->load(Yii::$app->request->post())) {
		   
                 $files = \yii\web\UploadedFile::getInstancesByName('file');
                 $post = \Yii::$app->request->post('Slideimg', '');
                 if($files){
                     $pathDefault = "/web/images/watermark";
                     $path   = Yii::getAlias('@storage') . $pathDefault;
                     $f = $files[0];
                     $genName    = time();
                     $fileName   = md5($genName).".".$f->extension;
                     $filePath   = "{$path}/{$fileName}";
                     $viewPath   = Yii::getAlias('@storageUrl') . "/images/watermark"; 
                     @unlink("{$model['file_path']}/{$model['name']}");
                     
                     $target     = "{$path}/mark_".$genName.".jpg";
                     if ($f->saveAs($filePath)) {
                         //\appxq\sdii\utils\VarDumper::dump($filePath);
                           // $sql  = "magick convert {$filePath} -resize 1300x450 {$target}";
                            //exec($sql, $out, $retval);
                            //@unlink($filePath);
                         $model->name = $fileName;//"mark_".$genName.".jpg";
                         $model->file_path = $path;
                         $model->view_path = $viewPath;
                         $model->detail = $post['detail'];
                         
                     }
                 } 
                 if($model->save()){
                             return \janpan\jn\classes\JResponse::getSuccess("Success");
                         }else{
                             return \janpan\jn\classes\JResponse::getError(\yii\helpers\Json::encode($model->errors));
                         }
	    } else {
		return $this->renderAjax('update', [
		    'model' => $model,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Deletes an existing Slideimg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) { 
            $model = $this->findModel($id); 
	    if ($model->delete()) {
		@unlink("{$model['file_path']}/{$model['name']}");
                return \janpan\jn\classes\JResponse::getSuccess("Success");
	    } else {
		return \janpan\jn\classes\JResponse::getError(\yii\helpers\Json::encode($model->errors));
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    public function actionDeletes() {
	if (Yii::$app->getRequest()->isAjax) {
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    if (isset($_POST['selection'])) {
		foreach ($_POST['selection'] as $id) {
		    $model = $this->findModel($id);
                    @unlink("{$model['file_path']}/{$model['name']}");
                    $model->delete();
		}
		$result = [
		    'status' => 'success',
		    'action' => 'deletes',
		    'message' => SDHtml::getMsgSuccess() . Yii::t('app', 'Deleted completed.'),
		    'data' => $_POST['selection'],
		];
		return $result;
	    } else {
		$result = [
		    'status' => 'error',
		    'message' => SDHtml::getMsgError() . Yii::t('app', 'Can not delete the data.'),
		    'data' => $id,
		];
		return $result;
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    
    /**
     * Finds the Slideimg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slideimg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slideimg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
