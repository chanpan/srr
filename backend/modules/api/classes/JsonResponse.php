<?php
namespace backend\modules\api\classes;
class JsonResponse {
    public static function response(){
        return \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
    /**
     * 
     * @param type $status array or object 
     * @param type $res array or object
     */
    public static function responseData($status, $res){
        self::response();
        $data=[];
        $data['status']=$status;
        $data['data']=$res;
        return $data;
    }
}
