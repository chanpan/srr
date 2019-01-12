<?php

namespace janpan\jn\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
class SlideTop extends \yii\base\Widget{
    public $image=[];
     
    public function run() {
        
        $this->registerScript();
        $this->registerScript();
            $template = "
                <div class='row justify-content-center'>
                    <div class='c'>
                        {image}                                  
                    </div>
                </div>
            "; 
              
            $imageStr = "";
            foreach($this->image as $k=>$v){
                $imageStr .= "
                    
                   <img class='item' src='{$v['src']}' >  
                        
                ";
            }
            $modelForm = ['image'=>$imageStr];
            $path = [];
            foreach ($modelForm as $key => $value) {
                $path["{" . $key . "}"] = $value;
            }
            $template = strtr($template, $path);     
            echo $template;
            //\appxq\sdii\utils\VarDumper::dump($template);
        
    }
    public function registerScript(){
        $view = $this->getView();
        \janpan\jn\assets\slidetop\SlideTopAssets::register($view);
        $js="
            $('.c').jCarousel({
                type:'slidey-down',
                carsize: {carwidth:760,carheight:1000},
                 auto: {
                    isauto:false,
                    interval:1000000
                 },

            });
        ";
        $view->registerJs($js);
        
    }
    public function CssRegister(){
       $view = $this->getView();
       $css="
            
        ";
       $view->registerCss($css);
    }
}
