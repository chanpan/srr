<?php

namespace frontend\modules\museum\controllers;

use yii\web\Controller;
use frontend\modules\sections\classes\JSection;
use frontend\modules\sections\classes\JContent;
use common\models\Sections;
use common\models\FileType;

 
class DefaultController extends Controller
{ 
    public function actionIndex()
    {
        \frontend\modules\sections\classes\JCounter::saveCounter();
                
        $section = JSection::getRootSection();         
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels'=>$section,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]); 
        return $this->render("index",[
            'dataProvider'=>$dataProvider
        ]);
        return $this->render('index');
    }
}
