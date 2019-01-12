<?php
namespace frontend\modules\sections\classes;
use yii\db\Exception;
class JSection extends \yii\base\Component{
    public static function getAll(){
        $data = \common\models\Sections::find()->where("public=1 AND rstat not in(0,3) AND id<>0")->all();
        return $data;
    }
    public $level_each_rows=[];
    
    /*pototype*/
    /**
     * 
     * @return object
     */
    public static function getRoot($public = ''){
       try{
            return self::getSessionByCondition('parent_id is null', 'one', $public);       
       } catch (yii\db\Exception $ex){
           return false;
       }
    }
    /**
     * 
     * @return object
     */
    public static function getPTYSectionById($id){
       try{
            $data = \common\models\Sections::find()->where('rstat not in(0,3) and id=:id',[":id"=>$id])->one();  
            if($data){
                return $data;
            }
       } catch (yii\db\Exception $ex){
           return false;
       }
    }
    
    
    
    /**
     * 
     * @param type $parent_id string '1'
     * @return object or false
     */
    public static function getRootSection(){
       try{
            return self::getSessionByCondition('parent_id = 0', 'all');       
       } catch (yii\db\Exception $ex){
           return false;
       }
    } 
    
    public static function getSectionArrById($id){
        $data = \common\models\Sections::find()->where(['parent_id'=>$id])->orderBy(['forder'=>SORT_ASC])->all();
        
    }
    
    public static function getChildren($id, $content=""){
        try{
            $section = \common\models\Sections::find()->where(['parent_id'=>$id])->andWhere('rstat not in(0,3)')->orderBy(['forder'=>SORT_ASC])->all();
            //ถ้าไม่เจอค้นจาก ID
            if(empty($section) && $content == "content"){
                $section = \common\models\Sections::find()->where(['id'=>$id])->andWhere('rstat not in(0,3)')->orderBy(['forder'=>SORT_ASC])->all();
            }
            
            $datas = [];             
            
            foreach($section as $s){
                //echo $s['id']." | ";
                $data = (new \yii\db\Query())
                    ->select('@pv:=`id` as data_id, tbl_sections.*')
                    ->from('tbl_sections')
                    ->innerJoin("(select @pv:={$s['parent_id']})tmp")
                    ->where("parent_id=@pv AND rstat not in(0,3)")->all();  
                    $datas = \yii\helpers\ArrayHelper::merge($datas, $section); 
            }
           
            return $section;
        } catch (Exception $ex) {
            return false;
        }
    }
 

    /**
     * 
     * @param type $menu_head
     * @param type $section
     * @param type $default != show default title
     * @return type
     */
    public static function getTitle($parent_id){
         $section = \common\models\Sections::findOne($parent_id);
         return $section;
    }
    /**
     * 
     * @param type $parent_id id 
     * @return boolean|array
     */
    public static function getBreadcrumb($parent_id, $url=''){
        try{
            $breadcrumbs = [                
            ]; 
            
            $sql="
               SELECT c.*
                FROM (
                    SELECT
                        @r AS _id,
                        (SELECT @r := parent_id FROM tbl_sections WHERE `id` = _id) AS parent_id,
                        @l := @l + 1 AS level
                    FROM
                        (SELECT @r := {$parent_id}, @l := 0) vars, tbl_sections m
                    WHERE @r <> 0) d
                JOIN tbl_sections c
                ON d._id = c.id  
                ORDER BY c.id ASC
            ";
            $data = \Yii::$app->db->createCommand($sql)->queryAll();
            $breadcrumbs=[];
            $url = ($url == '') ? '/sections/section' : $url;
            $breadcrumbs[] = [
                'label' =>'หน้าหลัก', 
                'url' =>$url,
                'icon'=>'fa-home'
            ];
            if($data){                
                
                foreach($data as $key => $d){              
                  $breadcrumbs[$key+1] = [
                      'label' =>$d['name'], 
                      'url' => [$url, 'id'=>$d['id']],
                      'icon'=>"{$d['icon']}"
                      ];                      
                }
                
                return $breadcrumbs;
                
            }else{
          
                return $breadcrumbs;
            }
                
        } catch (Exception $ex) {
            return false;
        }
    }

        /**
     * 
     * @param type $parent_id string '1'
     * @return object or false
     */
    public static function getSessionAll(){
       try{
            return self::getSessionByCondition('', 'all');       
       } catch (yii\db\Exception $ex){
           return false;
       }
    }
    /**
     * 
     * @param type $condition array ['id'=>$id]
     * @param type string type = 'all' , 'one'
     * @return boolean
     */
    private static function getSessionByCondition($condition, $type='all', $public=''){
        try{
            $public = ($public != "") ? $public : '1';
            $data = \common\models\Sections::find()->where("rstat not in(0,3) and public = {$public}");  
            if(!empty($condition)){
                $section = $data->andWhere($condition);
            }
            
            $section = $data->orderBy(['forder' => SORT_ASC]);
            if($type == 'one'){$section =$data->one();}
            else{$section=$data->all();}
            return $section;
        } catch (Exception $ex) {
            return false;
        }
    }
    /**
     * 
     * @param type $parent_id string '1'
     * @return object or false
     */
    public static function getSectionByParentId($parent_id, $type="all"){
       try{
            $condition=['parent_id' => $parent_id];
            return self::getSessionByCondition($condition, $type);       
       } catch (yii\db\Exception $ex){
           return false;
       }
    }
    /**
     * 
     * @param type $parent_id string '1'
     * @return object or false
     */
    public static function getSectionById($id, $type='one', $public=""){
       try{
            $condition=['id' => $id];
            $type = ($type != "") ? $type : 'one';
            return self::getSessionByCondition($condition, $type, $public);       
       } catch (yii\db\Exception $ex){
           return false;
       }
    }
    
}
