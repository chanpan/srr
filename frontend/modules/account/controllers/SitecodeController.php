<?php

namespace frontend\modules\account\controllers;

use Yii;
 

/**
 * Default controller.
 */
class SitecodeController extends \yii\web\Controller
{
     
    public function actionGetSite($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = []; 
        if (!is_null($q)) {
            $query = \common\models\Sitecode::find()
                    ->select(['id','name'])
                    ->where(['like', 'id', $q])
                    ->orWhere(['like', 'name', $q])
                    ->limit(20)->all();
            foreach($query as $k=>$v){
                $out['results'][$k] = ['id'=>$v['id'], 'text'=>"{$v['name']} ({$v['id']})"];//array_values($query);
            }
            
            return $out;
        }
         
        
    }
    public function actionCreate(){
        $model= new \common\models\Sitecode();
        if($model->load(Yii::$app->request->post())){
            if($model->validate() && $model->save()){
                return \janpan\jn\classes\JResponse::getSuccess("Success");
            }else{
                return \janpan\jn\classes\JResponse::getError(\yii\helpers\Json::encode($model->errors));
            } 
        }
        return $this->renderAjax("create",['model'=>$model]);
    }
 
}
