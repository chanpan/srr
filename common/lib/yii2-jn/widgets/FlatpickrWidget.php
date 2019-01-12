<?php
namespace janpan\jn\widgets;
use bs\Flatpickr\FlatpickrWidget as BaseFlatpickrWidget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
class FlatpickrWidget extends BaseFlatpickrWidget{
    public $groupBtn = [
        'toggle' => [
            'btnClass' => 'btn btn-default',
            'iconClass' => 'fa fa-calendar',
        ],
        'clear' => [
            'btnClass' => 'btn btn-default',
            'iconClass' => 'fa fa-remove',
        ],
    ];
    public function run()
    {
        return parent::run();         
    }
     
}
