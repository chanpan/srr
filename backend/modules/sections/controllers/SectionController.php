<?php

namespace backend\modules\sections\controllers;

use yii\web\Controller;
use backend\modules\sections\classes\JSection;
use backend\modules\sections\classes\JContent;
use common\models\Sections;
use Yii;
class SectionController extends Controller
{ 
    public function actionIndex(){
        return $this->redirect(['/sections/session-management']);
    }
}
