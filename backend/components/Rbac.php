<?php

namespace backend\components;
use Yii;
class Rbac extends \yii\base\Component {
   
    public static function getRbac() {
       $data = (new \yii\db\Query())
               ->select(['a.name', 'ac.parent'])
               ->from('auth_item as a')
               ->innerJoin('auth_item_child as ac', 'a.name = ac.child')
               ->where('a.type=2')->all();
       $moduleId        = (isset(Yii::$app->controller->module->id) && Yii::$app->controller->module->id != 'app-backend') ? Yii::$app->controller->module->id : '';
       $controllerId    = isset(Yii::$app->controller->id) ? Yii::$app->controller->id : '';
       $actionId        = isset(Yii::$app->controller->action->id) ? Yii::$app->controller->action->id : '';
       $rules = [];
       $n=0; 
       //\appxq\sdii\utils\VarDumper::dump($data);
       foreach($data as $key=>$v){
           $name_arr = explode('/', $v['name']);
           
           if(count($name_arr) == 1){
               //all controller
              if($controllerId==$name_arr[0]){
                  
                  $rules[$n]=[
                        'allow' => true,
                        'controllers' => [$name_arr[0]],
                        'roles' => [$v['parent']],
                  ];
                  $n+=1;
              }
           }
           elseif(count($name_arr) == 2){
            if($moduleId == ''){
                //controller/view
                if($controllerId==$name_arr[0] && $actionId == $name_arr[1]){
                    //\appxq\sdii\utils\VarDumper::dump($name_arr);
                    $rules[$n]=[
                            'allow' => true,
                            'controllers' => [$name_arr[0]],
                            'roles' => [$v['parent']],
                            'actions'=>[$name_arr[1]]
                    ];
                    $n+=1;
                }
            }else{
                //module/controller/view
                if($moduleId==$name_arr[0] && $controllerId==$name_arr[1]){
                    //\appxq\sdii\utils\VarDumper::dump($name_arr);
                    $rules[$n]=[
                            'allow' => true,
                            'controllers' => [$v['name']],
                            'roles' => [$v['parent']],
                    ];
                    $n+=1;
                }
            }
               //controller/action
           }elseif(count($name_arr) == 3){               
               //module/controller/action
               
               if($moduleId==$name_arr[0]  && $controllerId==$name_arr[1] && $actionId == $name_arr[2]){
                   $rules[$n]=[
                            'allow' => true,
                            'controllers' => ["{$name_arr[0]}/$name_arr[1]"],
                            'roles' => [$v['parent']],
                            'actions'=>[$name_arr[2]]
                    ];
                    $n+=1;
               }
               
           }
           
       }
         
       //
       return $rules;
       //exit();
    }
    

}
