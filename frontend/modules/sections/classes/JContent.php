<?php 
namespace frontend\modules\sections\classes;
use yii\db\Exception; 
class JContent {
    
    /**
     * 
     * @param type $content_id
     */
    public static function addTemplate($content_id){
        $check_choice = \common\models\ContentChoice::find()->where(['content_id'=>$content_id])->one();
        if(!$check_choice){
            $template = \common\models\Templates::find()->all();
            foreach($template as $t){
                $model                  = new \common\models\ContentChoice();
                $model->content_id      = $content_id;
                $model->type            = $t['type'];
                $model->label           = $t['label'];
                $model->default         = $t['default'];
                $model->forder          = $t['forder'];
                $model->save();
            }
        }
    }
    /**
     * 
     * @param type $content_id
     */
    public static function getChoice($content_id, $type){        
        try {
            $choice = \common\models\ContentChoice::find()->where(['content_id'=>$content_id, 'type'=>$type])->all();
            return $choice;
        } catch (Exception $ex) {
            return false;
        }
    }
    public static function getChoiceDefault($content_id){        
        try {
            $choice = \common\models\ContentChoice::find()->where(['content_id'=>$content_id, 'default'=>1])->one();
            return $choice;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @return object or false
     */
    public static function getContentAll($type = ""){
        try {
            $data = \common\models\Contents::find()
                    ->where('rstat not in(0,3)');                    
                     
            if($type == '2'){
                $content = $data->andWhere(['public'=>2])->orderBy(['forder'=>SORT_ASC]);//private
            }else{
                $content = $data->andWhere(['public'=>1])->orderBy(['forder'=>SORT_ASC]);//public
            }
            return $content->all();
        } catch (Exception $ex) {
            return false;
        }
    }
    /**
     * 
     * @param type $id  section_id
     * @return object or false
     */
    public static function getContentBySectionId($id, $type=''){
        try {
            $data = \common\models\Contents::find()
                    ->where('rstat not in(0,3)')
                    ->andWhere('section_id=:id',[':id'=>$id]);   
            if($type == '2'){
                $content = $data->andWhere(['public'=>2])->orderBy(['forder'=>SORT_ASC]);//private
            }else{
                $content = $data->andWhere(['public'=>1])->orderBy(['forder'=>SORT_ASC]);//public
            } 
            return $content->all();
        } catch (Exception $ex) {
            return false;
        }
    }
    /**
     * 
     * @param type $id  section_id
     * @return object or false
     */
    public static function getContentById($id){
        try {
            $content = \common\models\Contents::find()
                    ->where('rstat not in(0,3)')
                    ->andWhere('id=:id',[':id'=>$id])
                    ->one();
//            \appxq\sdii\utils\VarDumper::dump($content);
            return $content;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    public static function getIDContentBySectionIdAll($id){
       $section = JSection::getSectionById($id, 'all');
       $id_arr=[];
       foreach($section as $s){
           $data = self::getSub($s['id']);
           array_push($id_arr, $data);
       }
        
    }
    public static function getSub($id){
        
        $section = JSection::getSectionByParentId($id, 'all');
        if($section){
            foreach($section as $s){
                if($s['parent_id'] != '0'){
                    $section = self::getSub($s['id']);
                }
            }
        }
        return $section;
    }
    
}
