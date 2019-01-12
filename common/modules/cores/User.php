<?php
namespace common\modules\cores;
use Yii;
class User {
    public static function getProfileName(){
        $fname = isset(Yii::$app->user->identity->userProfile->firstname) ? Yii::$app->user->identity->userProfile->firstname : '';
        $lname = isset(Yii::$app->user->identity->userProfile->lastname) ? Yii::$app->user->identity->userProfile->lastname : '';
        return "{$fname} {$lname}";
    }
    public static function getProfileNameByUserId($user_id){
        $data = \common\models\User::findOne($user_id);
        if($data){
            $name = "{$data->userProfile->firstname}  {$data->userProfile->lastname}";
        }else{
            $name = "";
        }
        return $name;
    }
}
