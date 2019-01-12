<?php
namespace frontend\components;
use Yii;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\bootstrap\NavBar as BaseNavBar;
class NavBar extends BaseNavBar{
    public function init()
    {
        parent::init();
    }
    protected function renderToggleButton()
    {
        $bar = Html::tag('span', '', ['class' => 'icon-bar']);
        $screenReader = "<span class=\"sr-only\">{$this->screenReaderToggleText}</span>";
        $html = "";
        
        $html .= Html::button("{$screenReader}\n{$bar}\n{$bar}\n{$bar}", [
            'class' => 'navbar-toggle',
            'data-toggle' => 'collapse',
            'data-target' => "#{$this->containerOptions['id']}",
        ]); 
//        $html .= "<span style='margin-left:10px;'></span>";    
//        $html .= Html::button("{$screenReader}\n{$bar}\n{$bar}\n{$bar}", [
//            'class' => 'navbar-toggle',
//            'data-toggle' => 'push-menu',
//            'data-target' => "#{$this->containerOptions['id']}",
//        ]);
         
        return $html;    
    }
}
