<?php

namespace backend\modules\sections\controllers;

use yii\web\Controller;
use backend\modules\sections\classes\JSection;
use backend\modules\sections\classes\JContent;
use common\models\Sections;
use Yii;
class SessionManagementController extends Controller
{ 
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                //'only' => ['index'],
                'rules' => \backend\components\Rbac::getRbac(),
            ]
        ];
    }
    public function actionIndex(){    
        
        $id = \Yii::$app->request->get('id', '');        
        if($id){
            $content_section = JSection::getSectionById($id);
            $section = JSection::getChildren($id);  
            //\appxq\sdii\utils\VarDumper::dump($section);
        }else{
            $content_section = JSection::getRoot();            
            $section = JSection::getRootSection(); 
            
            
        }
        $public = isset($content_section) ? '1' : '2';
        
        $breadcrumb = JSection::getBreadcrumb($id, '/sections/session-management');//\yii\helpers\Url::to(['/sections/session-management']));
        $title = JSection::getTitle($id);        
        $content = isset($id) ? JContent::getContentBySectionId($id, 1) : JContent::getContentAll(1);        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels'=>$section,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        $contentProvider = new \yii\data\ArrayDataProvider([
            'allModels'=>$content,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);          

        //\appxq\sdii\utils\VarDumper::dump($contentProvider->allModels);

        return $this->render("index",[
            'dataProvider'=>$dataProvider,
            'contentProvider'=>$contentProvider,
                             'breadcrumb'=>isset($breadcrumb) ? $breadcrumb :'',
            'title'=>($title['id']==0) ? '' : $title['name'],
            'content_section'=>$content_section,
            'public'=>$public 
        ]);
    }
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
            $parent_id = Yii::$app->request->get('parent_id', '0');
            $public = Yii::$app->request->get('public', '');  
	    $model =  new Sections();
            $model->id          = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $model->rstat       = 1; 
            $model->create_by = Yii::$app->user->id;
            $model->create_date = new \yii\db\Expression('NOW()');  
            $model->public = $public;
            
	    if ($model->load(Yii::$app->request->post())) {
                //\appxq\sdii\utils\VarDumper::dump();
                $checkName = Sections::find()->where(['name'=>$_POST['Sections']['name']])->andWhere('rstat <> 3')->one();
                if(!empty($checkName)){
                    //return \janpan\jn\classes\JResponse::getError("{$_POST['Sections']['name']} ถูกใช้งานแล้ว");
                    return \janpan\jn\classes\JResponse::getWarning("ชื่อซ้ำ");
                }
		if ($model->save()) {
		    return \janpan\jn\classes\JResponse::getSuccess(\Yii::t('session', 'Create data complete'), $model);
		} else {
		   return \janpan\jn\classes\JResponse::getSuccess(\Yii::t('session', 'Create Error!'));
		}
	    } else {
		$parent_section = Sections::find()->where('rstat not in(0,3)')->all();
                $model->parent_id = $parent_id; 
		return $this->renderAjax('create', [
		    'model' => $model,
                    'parent_section'=>$parent_section
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    public function actionUpdate($id)
    {
        
	if (Yii::$app->getRequest()->isAjax) {
            $parent_id = Yii::$app->request->get('parent_id', '0');     
            
	    $model =  Sections::findOne($id);
             
	    if ($model->load(Yii::$app->request->post())) {
                $checkName = Sections::find()->where(['name'=>$_POST['Sections']['name']])->andWhere('id != :id  AND rstat <> 3', [':id'=>$id])->one();
                if(!empty($checkName)){
                    //return \janpan\jn\classes\JResponse::getError("{$_POST['Sections']['name']} ถูกใช้งานแล้ว");
                    return \janpan\jn\classes\JResponse::getWarning("ชื่อซ้ำ");
                } 
		if ($model->save()) {
		    return \janpan\jn\classes\JResponse::getSuccess(\Yii::t('session', 'Update data complete'), $model);
		} else {
		   return \janpan\jn\classes\JResponse::getSuccess(\Yii::t('session', 'Update Error!'));
		}
	    } else {
		$parent_section = Sections::find()->where('rstat not in(0,3)')->all();
        $model->parent_id = $parent_id; 
       
		return $this->renderAjax('update', [
		    'model' => $model,
                    'parent_section'=>$parent_section
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    public function actionDelete(){          
        if (Yii::$app->getRequest()->isAjax) {
            $id = \Yii::$app->request->post('id', '');	     
            $model = Sections::findOne($id); 
            $model->rstat = 3;
            if($model->id == 0){
                return \janpan\jn\classes\JResponse::getError(\Yii::t('session', 'Delete Error!'));
            }
            \backend\modules\sections\classes\CNParent::deleteSection($id);
	    if ($model->save()) {
                //\backend\modules\sections\classes\CNParent::deleteSection($id);
                return \janpan\jn\classes\JResponse::getSuccess(\Yii::t('session', 'Delete data complete'), $model);
            } else {
                return \janpan\jn\classes\JResponse::getError(\Yii::t('session', 'Delete Error!'));
            }
        } else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    
    public function actionForder(){
         
        $data = Yii::$app->request->post('data' , '');
        $data = explode(',', $data);
        $default = 10;
         
        foreach($data as $id){
            if($id != ""){
                $model = Sections::find()->where(['id'=>$id])->one();
                $model->forder = $default;
                $default += 10;
                $model->save();
            }
        }
    }
    public function actionForderFiles(){
         
        $data = Yii::$app->request->post('data' , '');
        $type_id = Yii::$app->request->post('type_id' , '');
        $data = explode(',', $data);
        $defaultOrder = 10; 
        //\appxq\sdii\utils\VarDumper::dump($data);
        foreach($data as $id){
            if($id != ""){
                $model = \common\models\Files::findOne($id);
                $model->forder = $defaultOrder;
                $defaultOrder += 10;
                $model->save();
            }
        }
        return \janpan\jn\classes\JResponse::getSuccess('success');
    } 
     public function actionOrderContent(){
         $data = Yii::$app->request->post('data' , '');
         $type = Yii::$app->request->post('type' , '');
         $data = explode(',', $data);
         $defaultOrder = 10; 
         foreach($data as $id){
             if($type === 'section'){
                 $model = \common\models\Sections::findOne($id);
             }else{
                 $model = \common\models\Contents::findOne($id);
             }
              
              $model->forder = $defaultOrder;
              $defaultOrder += 10;
              $model->save();
         }
         return \janpan\jn\classes\JResponse::getSuccess("success");
         //\appxq\sdii\utils\VarDumper::dump($data);
     }
    
}
