<?php
namespace janpan\jn\widgets;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
class ZoomImageWidget extends \yii\base\Widget{ 
    public $data = ['id'=>'', 'image'=>'', 'options'=>['id'=>'']]; 
    public function run()
    {   
         $view= $this->getView();
         \janpan\jn\assets\jzoom_image\JZoomAsset::register($view);
         $html = "";
         $this->data['options']['data-zoom-image']=$this->data['image'];
         $html .= Html::img($this->data['image'], $this->data['options']);
         $js="
             $('#".$this->data['options']['id']."').elevateZoom({
                    zoomType: 'inner',//'lens',
                    cursor: 'crosshair',
                    zoomWindowFadeIn: 500, //500
                    zoomWindowFadeOut: 750 //750
                   //lensSize    : 200,
               });
         ";
         $view->registerJs($js);
         return $html;         
         
    }
    public function registerAssets(){
        
    }
    public function registerCss(){
        $view= $this->getView();
        $css="
         
        ";
        $view->registerCss($css);

    } 
}
