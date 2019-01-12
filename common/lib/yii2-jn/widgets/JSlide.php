<?php

namespace janpan\jn\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
class JSlide extends \yii\base\Widget{
    public $image=[
        'src'=>'',
        'content'=>'',
        'options'=>[]
    ];
    public function init() {
        parent::init();
    }
    public function run() {
        parent::run();
        $this->registerScript();
        $this->CssRegister();
        $html = "";
        $html .= Html::beginTag("DIV", ['id'=>'jssor_1']);
        
            $html .= Html::beginTag("DIV", ['class'=>'jssorl-img', 'data-u'=>'slides','id'=>'lightgallery']);
                    foreach($this->image as $key=> $img){
                        $html .= Html::beginTag("DIV",['data-src'=>"{$img['src']}" , 'data-sub-html'=>"{$img['content']}"]);   
                            $this->image['options']['data-u']='image';
                            $html .= Html::a(Html::img($img['src'], $this->image['options']), '#', []);                         
                            $html .= Html::img($img['src'], ['data-u'=>'thumb', 'id'=>'chanpan'.$key]);                      
                        $html .= Html::endTag("DIV");
                    }
            $html .= Html::endTag("DIV");
            
            /* Thumbnail Navigator */            
//            $html .= Html::beginTag("DIV", ['class'=>'jssort101', 'data-u'=>'thumbnavigator','data-autocenter'=>"2",'data-scale-left'=>"0.75"]);
//                $html .= Html::beginTag("DIV" ,['data-u'=>'slides']);
//                    $html .= Html::beginTag("DIV" ,['data-u'=>'prototype', 'class'=>'p', 'style'=>'width:99px;height:66px;']);
//                        $html .= Html::tag("DIV", "", ['data-u'=>'thumbnailtemplate', 'class'=>'t']);
//                        $html .= Html::beginTag("svg" ,['viewBox'=>'0 0 16000 16000', 'class'=>'cv']);
//                            $html .= Html::tag("circle", "", ['class'=>"a" ,'cx'=>"8000" ,'cy'=>"8000" ,'r'=>"3238.1"]);
//                            $html .= Html::tag("line", "", ['class'=>"a" ,'x1'=>"6190.5", 'y1'=>"8000", 'x2'=>"9809.5" ,'y2'=>"8000"]);
//                            $html .= Html::tag("line", "", ['class'=>"a" ,'x1'=>"8000", 'y1'=>"9809.5", 'x2'=>"8000" ,'y2'=>"6190.5"]);
//                        $html .= Html::endTag("svg");
//                    $html .= Html::endTag("DIV");
//                $html .= Html::endTag("DIV");
//            $html .= Html::endTag("DIV");
            
          /*Arrow Navigator*/  
            $html .= Html::beginTag("DIV", ['data-u'=>"arrowleft", 'class'=>"jssora093", 'style'=>"width:50px;height:50px;top:0px;left:270px;" ,'data-autocenter'=>"2"]);
                 $html .= Html::beginTag("svg", ['viewBox'=>"0 0 16000 16000", 'style'=>"position:absolute;top:0;left:-260px;width:100%;height:100%;background: #d2ab66;"]);
                    $html .= Html::tag("circle", "", ['class'=>"c", 'cx'=>"8000", 'cy'=>"8000", 'r'=>"5920"]);
                    $html .= Html::tag("polyline", "", ['class'=>"a", 'points'=>"7777.8,6080 5857.8,8000 7777.8,9920 "]);
                    $html .= Html::tag("line", "", ['class'=>"a", 'x1'=>"10142.2", 'y1'=>"8000", 'x2'=>"5857.8", 'y2'=>"8000"]);
                 $html .= Html::endTag("svg");
            $html .= Html::endTag("DIV");
            
            $html .= Html::beginTag("DIV", ['data-u'=>"arrowright", 'class'=>"jssora093", 'style'=>"width:50px;height:50px;top:0px;right:30px;" ,'data-autocenter'=>"2"]);
                 $html .= Html::beginTag("svg", ['viewBox'=>"0 0 16000 16000", 'style'=>"position:absolute;top:0;left:0;width:100%;height:100%;    background: #d2ab66;"]);
                    $html .= Html::tag("circle", "", ['class'=>"c", 'cx'=>"8000", 'cy'=>"8000", 'r'=>"5920"]);
                    $html .= Html::tag("polyline", "", ['class'=>"a", 'points'=>"8222.2,6080 10142.2,8000 8222.2,9920 "]);
                    $html .= Html::tag("line", "", ['class'=>"a", 'x1'=>"5857.8", 'y1'=>"8000", 'x2'=>"10142.2", 'y2'=>"8000"]);
                 $html .= Html::endTag("svg");
            $html .= Html::endTag("DIV");
        
        $html .= Html::endTag("DIV");
        echo $html;
        
    }
    public function registerScript(){
        $view = $this->getView();
        \janpan\jn\assets\jslide\JSlideAsset::register($view);
        $js="$('#lightgallery').lightGallery();";
        $view->registerJs($js);
        
    }
    public function CssRegister(){
       $view = $this->getView();
       $css="
           /* jssor slider loading skin spin css */
.jssorl-009-spin img {
    animation-name: jssorl-009-spin;
    animation-duration: 1.6s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}

@keyframes jssorl-009-spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}


        .jssora093 {display:block;position:absolute;cursor:pointer; }
        
        .jssora093 .c {fill:none;stroke:#fff;stroke-width:400;stroke-miterlimit:10;}
        .jssora093 .a {fill:none;stroke:#fff;stroke-width:400;stroke-miterlimit:10;}
        .jssora093:hover {opacity:.8;}
        .jssora093.jssora093dn {opacity:.6;}
        .jssora093.jssora093ds {opacity:.3;pointer-events:none;}
        .jssort101 .p {position: absolute;top:0;left:0;box-sizing:border-box;background:#000;}        
        .jssort101 .p .cv {position:relative;top:0;left:0;width:100%;height:100%;border:2px solid #ccc;box-sizing:border-box;z-index:1;}
        .jssort101 .a {fill:none;stroke:#fff;stroke-width:400;stroke-miterlimit:10;visibility:hidden;}
        .jssort101 .p:hover .cv, .jssort101 .p.pdn .cv {border:none;border-color:transparent;}
        .jssort101 .p:hover{padding:2px;}
        .jssort101 .p:hover .cv {background-color:rgba(0,0,0,6);opacity:.35;}
        .jssort101 .p:hover.pdn{padding:0;}
        .jssort101 .p:hover.pdn .cv {border:2px solid #fff;background:none;opacity:.35;}
        
        .jssort101 .pav .cv {border-color:#fff;opacity:.35;}
        .jssort101 .pav .a, .jssort101 .p:hover .a {visibility:visible;}
        .jssort101 .t {position:absolute;top:0;left:0;width:100%;height:100%;border:none;opacity:.6;}
        .jssort101 .pav .t, .jssort101 .p:hover .t{opacity:1;}

           #jssor_1{
                position:relative;
                margin:0 auto;
                top:0px;
                left:0px;
                
                overflow:hidden;
                visibility:hidden;
                background-color:#24262e;
            }
           .jssorl-img{
                cursor:default;
                position:relative;
                top:0px;
                left:0px;
                width:720px;
                height:480px;
                overflow:hidden;
            }
           .jssort101{
                position:absolute;
                left:0px;
                top:0px;
                width:240px;
                height:480px;
                background-color:#000;
                position:absolute;left:0px;top:0px;width:240px;height:480px;background-color:#fff;
            }
        ";
       $view->registerCss($css);
    }
}
