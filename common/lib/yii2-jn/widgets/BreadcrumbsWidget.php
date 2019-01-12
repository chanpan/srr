<?php
namespace janpan\jn\widgets;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
class BreadcrumbsWidget extends \yii\base\Widget{ 
    public $breadcrumb = [];
    public function run()
    {   
         
        $this->registerAssets();
        $this->registerCss();
        $html = "";
        $html .= Html::beginTag("nav");
        $html .= Html::beginTag("ol",['class'=>'cd-breadcrumb custom-separator']);
            foreach($this->breadcrumb as $k=>$v){
                $icon = isset($v['icon']) ? $v['icon'] : '';
                $label = isset($v['label']) ? $v['label'] : '';
                $url = isset($v['url']) ? $v['url'] : '';
                $id = isset($v['url']['id']) ? $v['url']['id'] : '';
                $html .= Html::beginTag("li");
                    if(!empty($v['url'])){
                        if(!empty($v['url']['id'])){                            
                            $html .= Html::a("<i class='fa {$icon}'></i> {$label}", ["{$url[0]}?id={$id}"], ['']);
                        }else{
                            $url = isset($url) ? $url[0] : '';
                            $html .= Html::a("<i class='fa {$icon}'></i> {$label}", ["{$url}"], ['']);
                            //\appxq\sdii\utils\VarDumper::dump($url);
                        }                        
                    }else{
                        $html .= Html::a("<i class='fa {$icon}'></i> {$label}", "#", ['']);
                    }
                    
                $html .= Html::endTag("li"); 
            }             
               
        $html .= Html::endTag("ol");
        $html .= Html::endTag("nav");
        echo $html;
    }
    public function registerAssets(){
        $view = $this->getView();
        \janpan\jn\assets\BreadcrumbsAssets::register($view);
    }
    public function registerCss(){
        $view= $this->getView();
        $css="
         @media only screen and (min-width: 768px){
             
        }
        @media screen and (max-width: 768px){
             
        } 
        .cd-breadcrumb, .cd-multi-steps{
            width: 99%;
            max-width: 1377px;
            padding: 0.1em 0.5em;
            margin: 0em auto;
            background-color: #ffffff00; 
            border: none;
        }
        
        ";
        $view->registerCss($css);

    } 
}
