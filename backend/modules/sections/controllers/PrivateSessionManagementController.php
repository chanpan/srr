<?php

namespace backend\modules\sections\controllers;

use yii\web\Controller;
use backend\modules\sections\classes\JSection;
use backend\modules\sections\classes\JContent;
use common\models\Sections;
use Yii;
class PrivateSessionManagementController extends Controller
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
            $content_section = JSection::getSectionById($id, '', '2');
            //\appxq\sdii\utils\VarDumper::dump($content_section);
            $section = JSection::getChildren($id); 
            
             
        }else{
            $content_section = JSection::getRoot(2); 
            $section = JSection::getRootSection(2); 
            
        }
        $public = isset($content_section) ? '2' : '1';
       // \appxq\sdii\utils\VarDumper::dump($content_section['id']); 
         
        $breadcrumb = JSection::getBreadcrumb($id, '/sections/private-session-management');
        $title = JSection::getTitle($id);        
        $content = ($id != '') ? JContent::getContentBySectionId($id, 2) : JContent::getContentAll(2);
        
        
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
        
        return $this->render("index",[
            'dataProvider'=>$dataProvider,
            'contentProvider'=>$contentProvider,
            'breadcrumb'=>$breadcrumb,
            'title'=>($title['id']==0) ? '' : $title['name'],
            'content_section'=>$content_section,
            'public'=>$public
        ]);
    }
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
            $parent_id = Yii::$app->request->get('parent_id', '');             
	    $model =  new Sections();
            $model->id          = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $model->rstat       = 1; 
            $model->create_by = Yii::$app->user->id;
            $model->create_date = new \yii\db\Expression('NOW()');            
	    if ($model->load(Yii::$app->request->post())) {		 
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
            $parent_id = Yii::$app->request->get('parent_id', '');
            $public = Yii::$app->request->get('public', '');   
	    $model =  Sections::findOne($id);
            $model->public = $public;
	    if ($model->load(Yii::$app->request->post())) {		 
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
	    if ($model->save()) {
                return \janpan\jn\classes\JResponse::getSuccess(\Yii::t('session', 'Delete data complete'), $model);
            } else {
                return \janpan\jn\classes\JResponse::getError(\Yii::t('session', 'Delete Error!'));
            }
        } else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    
}
