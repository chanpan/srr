<?php
 
namespace frontend\modules\sections\classes;
use Yii;
use common\models\Sections;
use common\models\Contents;
use yii\db\Exception;
class JSectionQuery {
    public static function getSectionAll($id){
       $obj = new JSectionQuery();
       return $obj->getSectionTree($id);
       
    }
     
    function getSectionTree($id) {        
       // \appxq\sdii\utils\VarDumper::dump($id); 
        try{
            $id_arr = [$id];         
            $data_id=[];
            $n = true;
            $i = 0;
            array_push($data_id, $id);
            while ($n) {
                $id_str = implode(',', $id_arr);
                $data = Sections::find()->where("parent_id in($id_str) AND rstat not in(0, 3) AND public=1")->all();
                if(!$data){ 
                    $n=false;
                }else{ 
                    $id_arr = ['211'];                    
                    foreach($data as $d){
                        array_push($data_id, $d['id']);
                        array_push($id_arr, $d['id']);                    
                    }              

                }
                $i++;
            } 
            if(!$data_id){
                return '';
            }

            $data_id = implode(',', $data_id);
            //\yii\helpers\VarDumper::dump($data_id);
            $data = Contents::find()->where("section_id in($data_id)  AND rstat not in(0, 3) AND public =1")->all();
            return $data;
        } catch (Exception $ex) {

        }
        
    }

}
