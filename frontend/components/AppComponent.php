<?php

namespace frontend\components; 
use Yii;
use yii\base\Component;
use yii\web\UnauthorizedHttpException;

class AppComponent extends Component {
    
    public function init() {
        parent::init(); 
       
//        Yii::setAlias('storageUrl', Yii::$app->params['storageUrl']);
//        Yii::setAlias('backendUrl', Yii::$app->params['backendUrl']);
//        Yii::setAlias('frontendUrl', Yii::$app->params['frontendUrl']);
//        $params = \common\modules\cores\classes\CoreQuery::getOptionsParams();
//        Yii::$app->params = \yii\helpers\ArrayHelper::merge(Yii::$app->params, $params);
        \appxq\sdii\utils\VarDumper::dump('ok');
        //\appxq\sdii\utils\VarDumper::dump(\appxq\sdii\utils\SDUtility::string2Array(Yii::$app->params['brand_file_type']));
    }
    
    public static function navbarMenu() { 
      
    }

    public static function navbarRightMenu() {
        
    } 
}
