<?php
namespace frontend\modules\sections\classes;
use yii\db\Exception;
class JCounter extends \yii\base\Component{
 
    public static function saveCounter(){
      $model = new \common\models\View();
      $model->user_id = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : '';
      $model->ip = \Yii::$app->request->getUserIP();
      $model->date = new \yii\db\Expression('NOW()');
      $model->view_count  = 1;
      if($model->save()){
          return 'success';
      }else{
          return $model->errors;
      }
    }
    public static function getView(){
        $model = \common\models\View::find()->select('count(*)')->scalar();
        return $model;
    }
     
}
