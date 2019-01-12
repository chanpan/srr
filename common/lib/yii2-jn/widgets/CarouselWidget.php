<?php
 
namespace janpan\jn\widgets;
use yii\helpers\Html; 
class CarouselWidget extends \yii\base\Widget{
    //put your code here
    public $image=[
        'src'=>'',
        'title'=>'',
        'detail'=>'',
        'options'=>[]
    ];
    public $items=1;
    public $options; 
    public function init() {
        parent::init();
    }
    public function run() {
         $html = "";
         $html .= "<div id='myCarousel' class='carousel slide' data-ride='carousel'>";
            $html .= "<ol class='carousel-indicators'>";
            for($i=0; $i<= $this->items; $i++){
                $html .= "<li data-target='#myCarousel' data-slide-to='{$i}'></li>";
            }
            $html .= "</div>";
         
            $html .= "<div class='carousel-inner'>";
                foreach($this->image as $k=>$v){
                    $v['options']['alt'] = $v['title'];
                    $img = Html::img($v['src'], $v['options']);
                    if($k==0){
                        $html .= "
                        <div class='item active'>
                          {$img} 
                          <div class='carousel-caption'>
                            <h3>{$v['title']}</h3>
                            <p>{$v['detail']}</p>
                          </div>
                        </div>  
                      "; 
                    }else{
                        $html .= "
                        <div class='item'>
                          {$img} 
                          <div class='carousel-caption'>
                            <h3>{$v['title']}</h3>
                            <p>{$v['detail']}</p>
                          </div>
                        </div>  
                      "; 
                    }
                }
            $html .= "</div>";
            
        $html .= "
                        <a class='left carousel-control' href='#myCarousel' data-slide='prev'>
                            <span class='glyphicon glyphicon-chevron-left'></span>
                            <span class='sr-only'>Previous</span>
                        </a>
                     ";
         $html .= "
                        <a class='left carousel-control' href='#myCarousel' data-slide='next'>
                            <span class='glyphicon glyphicon-chevron-right'></span>
                            <span class='sr-only'>Next</span>
                        </a>
                     ";
         $html .= "</div>";
         echo $html;
    }
    public function registerScript(){
        $view = $this->getView(); 
        $js=" ";
        $view->registerJs($js);
         
    }
}
