<?php

namespace frontend\modules\sections\controllers;

use yii\web\Controller;
use frontend\modules\sections\classes\JSection;
use frontend\modules\sections\classes\JContent;
use common\models\Sections;
use Yii;
class SessionManagementController extends Controller
{ 
    public function actionIndex(){    
        return $this->redirect(['/sections/section']);
        \frontend\modules\sections\classes\JCounter::saveCounter();
                
        $id = \Yii::$app->request->get('id', '');        
        if($id){
            $content_section = JSection::getSectionById($id);
            $section = JSection::getChildren($id);
            $content = JSection::getChildren($id, "content");
            
        }else{
            $content_section = JSection::getRoot(); 
            $section = JSection::getRootSection(); 
            $content = JSection::getRootSection(); 
             
        }        
        $public = isset($content_section) ? '1' : '2';
        
        $breadcrumb = JSection::getBreadcrumb($id);
//        \appxq\sdii\utils\VarDumper::dump($breadcrumb);
        $title = JSection::getTitle($id);        
        //$content = isset($id) ? JContent::getContentBySectionId($id, 1) : JContent::getContentAll(1);
        
       
        
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
    
    public function actionGetDynamicItem(){
        $id = \Yii::$app->request->get('id', '');
        $data = \frontend\modules\sections\classes\JSectionQuery::getSectionAll($id);         
        //\appxq\sdii\utils\VarDumper::dump($id);
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels'=>$data,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        if(!$data){
            return '';
        }
          
        return $this->renderAjax("items/get-dynamic-item",[
            'dataProvider'=>$dataProvider,
            'data'=>$data
        ]);
    }
    public function actionGetKeywordSearch(){
        $term    = Yii::$app->request->get('term', '');
        $keyword =  \common\models\KeywordSearch::find()->where('word like :word', [':word'=>"%{$term}%"])->limit('20')->all();
        $output  = [];
        foreach($keyword as $k=>$v){
            $output[$k] = ['label'=>$v['word'], 'value'=>$v['word']];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $output;
    }
    public function actionSearch(){
        ini_set('memory_limit', '-1');
        $type_id    = Yii::$app->request->get('type_id', '');
        $txtsearch = Yii::$app->request->get('txtsearch', '');
        $fileType = \common\models\FileType::findOne($type_id);
        $data = \common\models\Files::find();
        
        $sections = Sections::find()->where('id <> 0 AND name like :name AND rstat not in(0,3)',[':name'=>"%{$txtsearch}%"])->orderBy(['forder'=>SORT_ASC]);
        $contents = \common\models\Contents::find()->where('name like :name AND rstat not in(0,3)', [':name'=>"%{$txtsearch}%"])->orderBy(['forder'=>SORT_ASC]);
        
        $model = $data->where('keywords LIKE :keywords OR details LIKE :details OR description LIKE :description  OR detail_meta LIKE :detail_meta  OR file_name_org LIKE :file_name OR meta_text LIKE :meta_text',[
            ':details'=>"%{$txtsearch}%",
            ':description'=>"%{$txtsearch}%",
            ':detail_meta'=>"%{$txtsearch}%",
            ':file_name'=>"%{$txtsearch}%",
            ':meta_text'=>"%{$txtsearch}%",
            ':keywords'=>"%{$txtsearch}%",        
                    
             
        ])->orderBy(['file_type'=>SORT_ASC])->groupBy(['id', 'file_name_org']);
        //\appxq\sdii\utils\VarDumper::dump($model->all());
           
        if($type_id == 0 || $type_id == ""){
            $type_id = 1;
        }
        //\appxq\sdii\utils\VarDumper::dump($type_id);
        $types = ['1', 'all'];
        if(!in_array($type_id, $types)){
            $model=$data->andWhere("file_type=:file_type", [":file_type"=>$type_id]);
            
            
            //\appxq\sdii\utils\VarDumper::dump($type_id);
        }else{
            $sectionProvider = new \yii\data\ActiveDataProvider([
                                                                'query' => $sections,
                                                                'pagination' => [
                                                                'pageSize' => 100,
                                                                ],
                                                                'sort' => [
                                                                'defaultOrder' => [
                                                                'id' => SORT_ASC,
                                                                ]
                                                                ],
                                                                ]);
            
            $contentProvider = new \yii\data\ActiveDataProvider([
                                                                'query' => $contents,
                                                                'pagination' => [
                                                                'pageSize' => 100,
                                                                ],
                                                                'sort' => [
                                                                'defaultOrder' => [
                                                                'id' => SORT_ASC,
                                                                ]
                                                                ],
                                                                ]);
        }
        
        if(isset($model)){
            $keyword =  \common\models\KeywordSearch::find()->where(['word'=>$txtsearch])->one();
            
            if(!$keyword){
                $keyword = new \common\models\KeywordSearch();
                $keyword->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                $keyword->status = 1;
                $keyword->date = date('Y-m-d H:i:s');
                $keyword->word = $txtsearch;
                if($keyword->save()){
                    
                }else{
                   //\appxq\sdii\utils\VarDumper::dump($keyword->errors);
                }
            }
             
        }
        $this->layout = "@frontend/themes/siriraj2/layouts/main-second"; 
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,  
                ]
            ],
        ]);  
        

        
        return $this->render("searchs/search",[
                             'sectionProvider'=>isset($sectionProvider)?$sectionProvider:'',
                             'contentProvider'=>isset($contentProvider)?$contentProvider:'',
            'dataProvider'=>$dataProvider,
            'txtsearch'=> isset($txtsearch) ? $txtsearch : '',
            'fileType'=>$fileType,
            'countSearch'=>count($model->all()) + count($sections->all())+ count($contents->all())
        ]); 
    }
}
