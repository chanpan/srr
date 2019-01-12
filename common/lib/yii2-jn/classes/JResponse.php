<?php
namespace janpan\jn\classes;
use Yii;
class JResponse {
    public static function init(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
    
    /**
     * 
     * @param type $message string message
     * @param type $model object or array  
     * @param type $action string 'CRUD'
     */
    public static function getSuccess($message, $model="", $action=''){
        self::init();
        $result = [
            'status' => 'success',
            'action' => "{$action}",
            'message' => "<strong><i class='glyphicon glyphicon-ok-sign'></i> Success!</strong> {$message}",
            'data' => $model,
        ];
        return $result;
    }
    /**
     * 
     * @param type $message string message
     * @param type $model object or array  
     * @param type $action string 'CRUD'
     */
    public static function getError($message , $model="", $action=""){
        self::init();
        $result = [
            'status' => 'error',
            'message' => "<strong><i class='fa fa-exclamation-circle'></i> Warning!</strong> {$message}",
            'data' => $model,
        ];
        return $result;
    }
    public static function getWarning($message , $model="", $action=""){
        self::init();
        $result = [
            'status' => 'warning',
            'message' => "<strong><i class='fa fa-exclamation-circle'></i></strong> {$message}",
            'data' => $model,
            'layout'=>'center'
        ];
        return $result;
    }
}
