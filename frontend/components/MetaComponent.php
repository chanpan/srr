<?php
namespace frontend\components;
use yii\base\Component;
use Yii;

class MetaComponent extends Component{

    public $keywords = 'คลังสมบัติของพิพิธภัณฑ์ศิริราช , Siriraj museum (Unravel) treasure , ค้นพบเรื่องราวประวัติศาสตร์ฝั่งธนฯ และการแพทย์ได้ที่นี่ , รอบรั้วศิริราช , พิพิธภัณฑ์ศิริราช , กรุงธนบุรี ,รวมบทความน่าอ่าน';
    public $description = 'ค้นพบเรื่องราวประวัติศาสตร์ฝั่งธนฯ และการแพทย์ได้ที่นี่';

    public $image = '';
    public function displaySeo(){

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->description,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $this->keywords,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:description',
            'content' => $this->description,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:image',
            'content' => $this->image,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:description',
            'content' => $this->description,
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:image',
            'content' => $this->image,
        ]);

    }
}