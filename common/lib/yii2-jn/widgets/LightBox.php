<?php
 
namespace janpan\jn\widgets;
use yii\helpers\Html; 
class LightBox extends \yii\base\Widget{
    //put your code here
    public $image=[
        'src'=>'',
        'content'=>'',
        'options'=>[]
    ];
    public $options; 
    public function init() {
        parent::init();
    }
    public function run() {
        parent::run();
        $html = "";
        $html .= Html::beginTag("DIV", ['class'=>'row']);
            $html .= Html::beginTag("DIV", ['class'=>'demo-gallery col-md-12 text-right']);
                $html .= Html::beginTag("DIV", ['id'=>'lightgallery']);
                    foreach($this->image as $key=>$value){
                        $html .= Html::beginTag("DIV", ['class'=>'flex-3','data-src'=>"{$value['src']}", 'data-sub-html'=>"{$value['content']}"]);
                            $html .= Html::beginTag("DIV", $this->options);
                                $html .= Html::a(Html::img($value['src'], $value['options']), '#', []);
                            $html .= Html::endTag("DIV");
                        $html .= Html::endTag("DIV");
                    }

                $html .= Html::endTag("DIV");         
            $html .= Html::endTag("DIV");
        $html .= Html::endTag("DIV"); 
        $this->registerScript();
        echo $html;
    }
    public function registerScript(){
        $view = $this->getView();
        \janpan\jn\assets\jlightbox\JLightBoxAsset::register($view);
        $js="$('#lightgallery').lightGallery();";
        $view->registerJs($js);
        $css ="
            .demo-gallery{
                height: auto;
                overflow: hidden;
            }
            #lightgallery{
                 
                display:flex;
                flex-direction:row;
                padding: 20px;
                flex-wrap:wrap;
            }
            .flex-3{
                padding:5px;
                
            }
            .max-img {
                max-width: 78px;
            }
        ";
        $view->registerCss($css);
    }
}
