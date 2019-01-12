<?php

namespace backend\modules\sections\controllers;

use Yii;
use common\models\ContentChoice;
use backend\modules\sections\models\FileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;
//upload images
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\image\drivers\Image;


/**
 * FileManagementController implements the CRUD actions for ContentChoice model.
 */
class FileManagementController extends Controller
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
     * Lists all ContentChoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ContentChoice model.
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
     * Creates a new ContentChoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) { 
            
            
            $content_id         = \Yii::$app->request->get('content_id', '');
            $filet_id           = \Yii::$app->request->get('filet_id', '');
            $model              = \common\models\Files::findOne($filet_id); 
	    if ($model->load(Yii::$app->request->post())) {
                
                $post = Yii::$app->request->post()['Files'];
                $model->details = $post['details'];
                $model->file_name_org = $post['file_name_org'];
                //$model->file_thumbnail = $post['file_thumbnail'];
                $model->keywords = $post['keywords'];
                $model->url_origin_file = $post['url_origin_file'];
//                \appxq\sdii\utils\VarDumper::dump();
                
                $checkName = \common\models\Files::find()->where(['file_name_org'=>$post['file_name_org']])->andWhere('id != :id', [':id'=>$filet_id])->one();
                if(!empty($checkName)){
                    return \janpan\jn\classes\JResponse::getWarning("ชื่อซ้ำ");
                } 
                
                if ($model->save()) {		 
                    return \janpan\jn\classes\JResponse::getSuccess(Yii::t('file', 'Update completed.'), $model);
                } else {
                    return \janpan\jn\classes\JResponse::getError(Yii::t('app', 'Can not update the data.'), $model);
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
     * Updates an existing ContentChoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
	    if ($model->load(Yii::$app->request->post())) { 
                
                $checkName = \common\models\Files::find()->where(['file_name_org'=>$_POST['Files']['file_name_org']])->andWhere('id <> :id', [':id'=>$id])->one();
                if(!empty($checkName)){
                    return \janpan\jn\classes\JResponse::getWarning("ชื่อซ้ำ");
                    //return \janpan\jn\classes\JResponse::getError("{$_POST['Files']['file_name_org']} ถูกใช้งานแล้ว");
                }
                
                if($model->default == 1){
                    $choice = ContentChoice::find()->where(['content_id'=>$model->content_id, 'type'=>$model->type])->all();
                    foreach($choice as $c){
                        $c->default = 0;
                        $c->update();
                    }
                    //default
                    //ContentChoice::updateAll(['default'=>0, 'type'=>$model->type, 'content_id'=>$model->content_id]); 
                    //\Yii::$app->db->createCommand()->update($table, $columns, $condition, $params);
                }  
		if ($model->save()) {		 
                    return \janpan\jn\classes\JResponse::getSuccess(Yii::t('file', 'Update completed.'), $model);
                } else {
                    return \janpan\jn\classes\JResponse::getError(Yii::t('app', 'Can not update the data.'), $model);
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
     * Deletes an existing ContentChoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
	if (Yii::$app->getRequest()->isAjax) { 
            $id = \Yii::$app->request->post('id', '');
            $model = $this->findModel($id); 
	    if ($model->delete()) {		 
                return \janpan\jn\classes\JResponse::getSuccess(Yii::t('file', 'Deleted completed.'), $model);
	    } else {
		return \janpan\jn\classes\JResponse::getError(Yii::t('app', 'Can not delete the data.'), $model);
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
		    $this->findModel($id)->delete();
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
     * Finds the ContentChoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContentChoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContentChoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
 
    public function actionUploadFile()
    {
        ini_set('post_max_size', '11164M');
        ini_set('upload_max_filesize', '11164M');

        $file_type = Yii::$app->request->get('file_type', '');
        $content_id = Yii::$app->request->get('content_id', '');
        $model = new \common\models\Files();
        $model->file_type       = $file_type;
        
         if (Yii::$app->request->isPost) {    
            $file_type = Yii::$app->request->post('file_type', '');
            $content_id = Yii::$app->request->post('content_id', '');
            $status = Yii::$app->request->post('status', ''); //video of footage
            
            $model->file_type       = $file_type;
            $folderName                 = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $files                      = UploadedFile::getInstancesByName('name'); 
            $file_thumbnail             = '';
            //\appxq\sdii\utils\VarDumper::dump($model->file_type);
            if ($files) {
                
                 //return \janpan\jn\classes\JResponse::getSuccess("success");
                    $folder             = "/web/files";
                    $path               = Yii::getAlias('@storage') . "{$folder}/{$folderName}";
                    if($file_type == '2'){
                        \backend\modules\sections\classes\JFiles::CreateDir($path, true); //create folder
                    }else{
                        \backend\modules\sections\classes\JFiles::CreateDir($path, false); //create folder
                    }
                    
                    $out=[];
                    $obj=['type'=>''];
                    $file_view = "";
                    $require_file = '';
                    foreach ($files as $file) {                        
                        $fileName       = $file->baseName . '.' . $file->extension;
                        $realFileName   = md5($folderName . time());// . '.' . $file->extension;
                        $filePath       = "{$path}/{$realFileName}";
                        $fileType       = explode('/', $file->type);
                        $thumbnail      = "{$path}/thumbnail/{$realFileName}";                        
                        $viewPath       = Yii::getAlias('@storageUrl') . "/files/{$folderName}";
                        $fileNames      = "{$realFileName}.{$obj['type']}";
                        //\appxq\sdii\utils\VarDumper::dump($file);
                        // \appxq\sdii\utils\VarDumper::dump($fileType[0]);
                        $objType = ['vob','avi','mpeg2','wmv','rmvb','3gp','flv','m4v','mkv','mov','mpeg','mpg','mts','webm','wmv'];
                        $fileNameArr = explode(".", $file->name);
                        //
                        if($fileType[0] === 'image'){//images   
                            $watermark = \backend\models\Watermark::find()->where(['default'=>1, 'type'=>'2'])->one();
                            $obj = \backend\modules\sections\classes\JFiles::uploadImage($file, $filePath, $fileType,$thumbnail,$watermark);
                            $objType = isset($obj['type']) ? $obj['type'] : '';
                            $objDetail = isset($obj['detai']) ? $obj['detai'] : '';
                            $fileNames = "{$realFileName}_mark.{$objType}";
                            $file_view = "{$realFileName}_preview.jpg";
                            $detail_meta =  "{$objDetail}";
                            $description = "";
                            
                            $require_file = "{$realFileName}_2124.{$obj['type']},{$realFileName}_1024.{$obj['type']}";
                            
                        }else if($fileType[0] === 'video' || in_array(end($fileNameArr), $objType)){
                             
                           $watermark = \backend\models\Watermark::find()->where(['default'=>1, 'type'=>'3'])->one(); 
                           $obj = \backend\modules\sections\classes\JFiles::uploadVideo($file,$filePath, $watermark, $status);                           
                           //\appxq\sdii\utils\VarDumper::dump($obj['file_thumbnail']);
                           if($obj['default'] == "2"){
                               $fileNames = "{$realFileName}.{$obj['type']}";
                           }else{
                               $fileNames = "{$realFileName}_marks.{$obj['type']}";
                           }
                           
                           $file_thumbnail = $obj['file_thumbnail'];
                           $file_view = $fileNames;
                           $detail_meta =  "{$obj['detai']}";
                           $description = "";
                            
                        }else if($fileType[0] === 'application' && !in_array(end($fileNameArr), $objType)){//docx pdf 
                             
                           $obj = \backend\modules\sections\classes\JFiles::uploadDocx($file,$filePath,$path,$realFileName);
                            $objType = isset($obj['type']) ? $obj['type'] : '';
                            $objDetail = isset($obj['detai']) ? $obj['detai'] : '';
                            
                           $fileNames = "{$realFileName}.{$objType}";
                           $file_view = $fileNames;
                           $detail_meta =  "{$objDetail}";
                           $description = isset($obj['description']) ? $obj['description'] : '';
                           //\appxq\sdii\utils\VarDumper::dump($fileName);
                        }else if($fileType[0] === 'audio'){
                           
                           $obj = \backend\modules\sections\classes\JFiles::uploadAudio($file,$filePath);
                           $objType = isset($obj['type']) ? $obj['type'] : '';
                           $objDetail = isset($obj['detai']) ? $obj['detai'] : '';
                           $fileNames = "{$realFileName}.{$objType}";
                           $file_view = $fileNames; 
                            $detail_meta =  "{$objDetail}";
                           $description = "";
                           //\appxq\sdii\utils\VarDumper::dump($detail_meta);
                        }else{
                            $obj = \backend\modules\sections\classes\JFiles::uploadDocx($file,$filePath);
                            //\appxq\sdii\utils\VarDumper::dump($obj);
                            $objType = isset($obj['type']) ? $obj['type'] : '';
                            $objDetail = isset($obj['detai']) ? $obj['detai'] : '';
                            $fileNames = "{$realFileName}.{$objType}";
                            $detail_meta =  "{$objDetail}";
                            $file_view = $fileNames;
                            $detail_meta =  "{$objDetail}";
                            $description = isset($obj['description']) ? $obj['description'] : '';
                            
                        }
                        
                        $save_data = \backend\modules\sections\classes\JFiles::Save($model, "{$fileNames}", $content_id, $viewPath, $fileName, $file, "{$folder}/{$folderName}", $file_view,$detail_meta,$description, $require_file, $file_thumbnail);
                    }
                    return \janpan\jn\classes\JResponse::getSuccess("Upload {$realFileName} Success"); 
                }             
         }
        
        return $this->renderAjax('upload-file' , [
            'model'=>$model,
            'content_id'=>$content_id,
            'file_type'=>$file_type
        ]);
    }
    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new \InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                @unlink($file);
            }
        }
        rmdir($dirPath);
    }
    public function actionDeleteFile(){
        try {
            $id= Yii::$app->request->post('id', '');
            $model = \common\models\Files::find()->where(['id'=>$id])->one();            
            if($model){
                if ($model->delete()) {  
                    $filename = Yii::getAlias('@storage') . "{$model->dir_path}/{$model->file_name}";
                    $thumbnail = Yii::getAlias('@storage') . "{$model->dir_path}/thumbnail/{$model->file_name}";
                    $this->deleteDir(Yii::getAlias('@storage') . "{$model->dir_path}");              
                    return \janpan\jn\classes\JResponse::getSuccess("Delete Success");
                } else {
                    return \janpan\jn\classes\JResponse::getError("Error");
                }
            }
        } catch (\yii\db\Exception $ex) {
            
        }
    }
     
    
   private function removeUploadDir($dir){
        BaseFileHelper::removeDirectory($dir);
  }

    
    
}
