<?php

namespace backend\modules\api\controllers;
use backend\modules\api\classes\JsonResponse;
class SectionController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $section = \backend\modules\api\models\Sections::find()->where('parent_id=0 and rstat not in(0,3)')->all();
        if($section){
            return JsonResponse::responseData(true, $section);
        } 
    }

}
