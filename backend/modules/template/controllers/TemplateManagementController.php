<?php

namespace backend\modules\template\controllers;
use yii\web\UploadedFile;
use Yii;
class TemplateManagementController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionFormRequest()
    {
        if(\Yii::$app->request->post()){
            $option_name = \Yii::$app->request->post('option_name', '');
            $option_value = \Yii::$app->request->post('option_value', '');
            \backend\modules\cores\classes\CoreOption::update($option_name, $option_value);
            return \janpan\jn\classes\JResponse::getSuccess("success");
        }
        return $this->render('form-request');
    }
    public function actionWaterMarkImage(){
        $model = \backend\models\Watermark::find()->where(['type'=>2])->orderBy(['default'=>SORT_DESC]);
        
        $provider = new \yii\data\ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC 
                ]
            ],
        ]);
        return $this->render('mark-image/water-mark-image',[
            'dataProvider'=>$provider
        ]);
    }
    public function actionWaterMarkVideo(){
        $model = \backend\models\Watermark::find()->where(['type'=>3])->orderBy(['default'=>SORT_DESC]);
        
        $provider = new \yii\data\ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC 
                ]
            ],
        ]);
        return $this->render('mark-image/water-mark-video',[
            'dataProvider'=>$provider
        ]);
    }
    public function actionUpdate($id){
        $model = \backend\models\Watermark::findOne($id);
        $type = \Yii::$app->request->get('type', '');
        
        //\appxq\sdii\utils\VarDumper::dump($type);
        if (Yii::$app->request->isPost) { 
            $folderName = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $files      = UploadedFile::getInstancesByName('file');
            $post = \Yii::$app->request->post('Watermark', '');
            $default_image = $post['default_image'];
            
            
            if($post['default'] == 1){
                $defaults = \backend\models\Watermark::find()->where(['type'=>$type])->all();   
                 
                foreach($defaults as $k=>$v){
                    $v->default = 0;
                    $v->update();
                }  
            }            
            if($files){                
                @unlink(Yii::getAlias('@storage')."/{$model->path}/{$model->name}");
                
                $pathDefault = "/web/images/watermark";
                $path   = Yii::getAlias('@storage') . $pathDefault;             
                \backend\modules\sections\classes\JFiles::CreateDir($path, FALSE);
                foreach($files as $f){
                    $genName    = time();
                    $fileName   = md5($genName).".".$f->extension; 
                    $filePath   = "{$path}/{$fileName}";
                    $target     = "{$path}/mark_".$genName.".png";
                    if ($f->saveAs($filePath)) {
                        $sql  = "magick convert {$filePath} -resize 200x200 {$target}";
                        if($default_image == "1"){
                            $sql  = "magick convert {$filePath} {$target}";
                        }
                        exec($sql, $out, $retval);
                        @unlink($filePath);
                    }
                    $model->name = "mark_".$genName.".png";         
                    $model->path = "/images/watermark";
                }   
            }
            $model->code    = $post['code'];
            $model->default = $post['default'];
            $model->detail  = $post['detail'];
            if($model->save()){
                return \janpan\jn\classes\JResponse::getSuccess("Success");
            }else{
                return \janpan\jn\classes\JResponse::getError("Error");
            }           
            
        }
        return $this->renderAjax('mark-image/update',[
            'model'=>$model
        ]);
    }

}
