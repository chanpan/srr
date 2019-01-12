<?php

use backend\models\Log;
use backend\widgets\Menu;

$moduleID = Yii::$app->controller->module->id;
$controllerID = Yii::$app->controller->id;
$actionID = Yii::$app->controller->action->id;

/* @var $this \yii\web\View */
?>
<aside class="main-sidebar">
    <section class="sidebar">

        <?=
        Menu::widget([
            'options' => ['class' => 'sidebar-menu'],
            'items' => [
                [
                    'label' => Yii::t('_app', 'Dashboard'),
                    'url' => ['/'],
                    'icon' => '<i class="fa fa-tachometer"></i>',
                    'active' => ($controllerID == 'site' && $actionID=="index") ? TRUE : FALSE,
                    'visible' => (Yii::$app->user->can('administrator') || Yii::$app->user->can('admin')),
                ], 
                [
                    'label' => Yii::t('appmenu', 'คลังสมบัติของของพิพิธภัณฑ์ศิริราช'),
                    'url' => ['/sections/session-management'],
                    'icon' => '<i class="fa fa-folder"></i>',
                    'active' => ($moduleID == 'sections' && $controllerID == 'session-management') ? TRUE : FALSE,
                    'visible' => (Yii::$app->user->can('administrator') || Yii::$app->user->can('admin')),
                ], 
                [
                    'label' => ' จัดการใบคำร้อง',
                    'url' => ['/order/order-management'],
                    'icon' => "<img src='". \yii\helpers\Url::to('@web/images/cart-icon.png')."' style='width:25px;'>  ",
                    'active' => ($moduleID == 'order') ? TRUE : FALSE,
                    'visible' => (Yii::$app->user->can('administrator') || Yii::$app->user->can('admin')),
                ],
                [
                    'label' => Yii::t('appmenu', 'Users Management'),
                    'url' => ['/user/index'],
                    'icon' => '<i class="fa fa-users"></i>',
                    'visible' => Yii::$app->user->can('administrator'),
                ],
//                [
//                    'label' => Yii::t('sitecode', 'Site Code'),
//                    'url' => ['/sitecode/index'],
//                    'icon' => '<i class="fa fa-id-card-o"></i> ',
//                    'visible' => Yii::$app->user->can('administrator'),
//                ],
                [
                    'label' => Yii::t('appmenu', 'Slider Image'),
                    'url' => ['/slideimg'],
                    'icon' => '<i class="fa fa-picture-o"></i> ',
                    'visible' => Yii::$app->user->can('administrator'),
                    'active' => ($controllerID == 'slideimg') ? TRUE : FALSE,
                ],
//                [
//                    'label' => Yii::t('appmenu', 'Themes Frontend'),
//                    'url' => ['/theme'],
//                    'icon' => '<i class="fa fa-rocket"></i> ',
//                    'visible' => Yii::$app->user->can('administrator'),
//                    'active' => ($controllerID == 'theme') ? TRUE : FALSE,
//                ],
                [
                    'label' => Yii::t('appmenu', 'Website Traffic Statistics'),
                    'url' => ['/viewcountermanagement/view-count'],
                    'icon' => '<i class="fa fa-eye"></i>',
                    'visible' => Yii::$app->user->can('administrator'),
                    'active' => ($moduleID=='viewcountermanagement' && $controllerID == 'view-count'&&  $actionID=="index") ? TRUE : FALSE,
                ],
                [
                    'label' => Yii::t('_app', 'Report Download'),
                    'url' => ['/viewcountermanagement/view-count/report-download'],
                    'icon' => '<i class="fa fa-cloud-download"></i>',
                    'visible' => Yii::$app->user->can('administrator'),
                    'active' => ($moduleID=='viewcountermanagement' && $controllerID == 'view-count' &&  $actionID=="report-download") ? TRUE : FALSE,   
                ],
                [
                    'label' => Yii::t('appmenu', 'Templates'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-columns"></i>',
                    'options' => ['class' => 'treeview'],
                    'visible' => Yii::$app->user->can('administrator'),
                    'items' => [
                        [
                            'label' => Yii::t('appmenu', 'Request Form'),
                            'url' => ['/template/template-management/form-request'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                            'active' => ($moduleID == 'template' && $controllerID == 'template-management' && $actionID == "form-request") ? TRUE : FALSE,
                        ], [
                            'label' => Yii::t('appmenu', 'Watermark Image'),
                            'url' => ['/template/template-management/water-mark-image'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                        ], [
                            'label' => Yii::t('appmenu', 'Watermark Video'),
                            'url' => ['/template/template-management/water-mark-video'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                        ],
//                        [
//                            'label' => Yii::t('appmenu', 'Example Data'),
//                            'url' => ['/example-data'],
//                            'icon' => '<i class="fa fa-angle-double-right"></i>',
//                            'visible' => Yii::$app->user->can('administrator'),
//                        ]
                    ],
                ],
                [
                    'label' => Yii::t('appmenu', 'Pages'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-file"></i>',
                    'options' => ['class' => 'treeview'],
                    'visible' => Yii::$app->user->can('administrator'),
                    'items' => [
                        [
                            'label' => Yii::t('appmenu', 'About Us'),
                            'url' => ['/site/template-about'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                             'active' => ($controllerID == 'site' && $actionID == "template-about") ? TRUE : FALSE,
                              
                        ], [
                            'label' => Yii::t('appmenu', 'Contact Us'),
                            'url' => ['/site/template-contact'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'active' => ($controllerID == 'site' && $actionID == "template-contact") ? TRUE : FALSE,
                            'visible' => Yii::$app->user->can('administrator'),
                        ]
                    ],
                   
                ],
                [
                    'label' => Yii::t('appmenu', 'Authentication'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-cogs"></i>',
                    'options' => ['class' => 'treeview'],
                    'visible' => (Yii::$app->user->id == 1),
                    'items' => [
                        [
                            'label' => Yii::t('appmenu', 'Role'),
                            'url' => ['/rbac/access/role'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                        ],
                        [
                            'label' => Yii::t('appmenu', 'Permission'),
                            'url' => ['/rbac/access/permission'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                        ]
                    ],
                ],
                [
                    'label' => Yii::t('appmenu', 'Settings'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-cog"></i>',
                    'options' => ['class' => 'treeview'],
                    'visible' => (Yii::$app->user->id == 1),
                    'items' => [
                        [
                            'label' => Yii::t('backend', 'Gii'),
                            'url' => ['/gii'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => YII_ENV_DEV,
                        ],
                        ['label' => Yii::t('appmenu', 'File manager'), 'url' => ['/file-manager/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
//                        [
//                            'label' => Yii::t('backend', 'DB manager'),
//                            'url' => ['/db-manager/default/index'],
//                            'icon' => '<i class="fa fa-angle-double-right"></i>',
//                            'visible' => Yii::$app->user->can('administrator'),
//                        ],
//                        [
//                            'label' => Yii::t('backend', 'System information'),
//                            'url' => ['/phpsysinfo/default/index'],
//                            'icon' => '<i class="fa fa-angle-double-right"></i>',
//                            'visible' => Yii::$app->user->can('administrator'),
//                        ],
                        ['label' => Yii::t('appmenu', 'Key storage'), 'url' => ['/key-storage/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('appmenu', 'Cache'), 'url' => ['/service/cache'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('appmenu', 'Clear assets'), 'url' => ['/service/clear-assets'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        [
                            'label' => Yii::t('appmenu', 'Logs'),
                            'url' => ['/log/index'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'badge' => Log::find()->count(),
                            'badgeOptions' => ['class' => 'label-danger'],
                        ],
                    ],
                ],
            ],
        ])
        ?>
    </section>
</aside>
<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .skin-blue .sidebar-menu>li a {
        font-size: 10pt;
    }
    .sidebar-menu>li>a>.fa, .sidebar-menu>li>a>.glyphicon, .sidebar-menu>li>a>.ion {
        width: 30px;
        font-size: 18pt;
        /* line-height: 10px; */
    }
    .skin-blue .main-header .logo {
        background-color: #ffffff;
        color: #525252;
        border-bottom: 0 solid transparent;
        font-family: sans-serif;
    }
    .skin-blue .main-header .logo:hover {
        background-color: #ffffff;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>