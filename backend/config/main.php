<?php
use common\behaviors\GlobalAccessBehavior;
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);
 
use developeruz\db_rbac\Yii2DbRbac;
$config = [
    'id' => 'app-backend',
    'homeUrl' => Yii::getAlias('@backendUrl'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'site/index',
    'language'=>'th-TH',
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@storageUrl',
                    'basePath' => '@storage',
                    'path' => '/',
                    'access' => ['read' => 'administrator', 'write' => 'administrator'],
                    'options' => [
                       'attributes' => [
                            [
                                'pattern' => '#.*(\.gitignore|\.htaccess)$#i',
                                'read' => false,
                                'write' => false,
                                'hidden' => true,
                                'locked' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ], 
    'components' => [
        
        'image' => [  
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['en-US', 'th-TH'], // List of available languages (icons only)
            'cookieName' => 'language', // Name of the cookie.
            'expireDays' => 64, // The expiration time of the cookie is 64 days.
            'callback' => function() {
                if (!\Yii::$app->user->isGuest) {
                    //		    $user = \Yii::$app->user->identity;
                    //		    $user->language = \Yii::$app->language;
                    //		    $user->save();
                }
            }
        ],
        'request' => [
            
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'csrfParam' => '_csrf-backend',
//            'baseUrl' => 'backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'app-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php'),
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
        ],
        'template' => [
            'class' => 'backend\modules\template\Module',
        ],
        'cores' => [
            'class' => 'backend\modules\cores\Module',
        ],
        'viewcountermanagement' => [
            'class' => 'backend\modules\viewcountermanagement\Module',
        ],
        'auth' => [
            'class' => 'backend\modules\auth\Module',
        ],
        'order' => [
            'class' => 'backend\modules\order\Module',
        ],
        'sections' => [
            'class' => 'backend\modules\sections\Module',
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
//        'section_management' => [
//            'class' => 'backend\modules\section_management\Module',
//        ],
//        'content_management' => [
//            'class' => 'backend\modules\content_management\Module',
//        ],
//        'secret_content_management' => [
//            'class' => 'backend\modules\secret_content_management\Module',
//        ],
//        'api' => [
//            'class' => 'backend\modules\api\Api',
//        ],
        'db-manager' => [
            'class' => 'bs\dbManager\Module',
            // path to directory for the dumps
            'path' => '@root/backups',
            // list of registerd db-components
            'dbList' => ['db'],
            'as access' => [
                'class' => 'common\behaviors\GlobalAccessBehavior',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ],
        'phpsysinfo' => [
            'class' => 'bs\phpSysInfo\Module',
            'as access' => [
                'class' => 'common\behaviors\GlobalAccessBehavior',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ],
        'rbac' => [
            'class' => 'backend\modules\cores\JYii2DbRbac',
            'as access' => [
                'class' => 'common\behaviors\GlobalAccessBehavior',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ],
    ],
//    'as globalAccess' => [
//        'class' => 'common\behaviors\GlobalAccessBehavior',
//        'rules' => [
//            [
//                'controllers' => ['site'],
//                'allow' => true,
//                'actions' => ['login'],
//                'roles' => ['?'],
//            ],
//            [
//                'controllers' => ['site'],
//                'allow' => true,
//                'actions' => ['logout'],
//                'roles' => ['@'],
//            ],
//            [
//                'controllers' => ['site'],
//                'allow' => true,
//                'actions' => ['error'],
//                'roles' => ['?', '@'],
//            ],
//            [
//                'controllers' => ['user'],
//                'allow' => true,
//                'roles' => ['administrator'],
//            ],
//            [
//                'controllers' => ['user'],
//                'allow' => false,
//            ],
////            [
////                'allow' => true,
////                'roles' => ['administrator'],
////            ],
//        ],
//    ],
    'as beforeAction' => [
        'class' => 'common\behaviors\LastActionBehavior',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['bootstrap']['log'] = [
        'class' => 'common\components\LanguageSelector',
        'supportedLanguages' => ['en-US', 'th-TH'], //กำหนดรายการภาษาที่ support หรือใช้ได้
    ];
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*'],
        'as access' => [
            'class' => 'common\behaviors\GlobalAccessBehavior',
            'rules' => [
                [
                    'allow' => true,
                ],
            ],
        ],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*'],
        'as access' => [
            'class' => 'common\behaviors\GlobalAccessBehavior',
            'rules' => [
                [
                    'allow' => true,
                ],
            ],
        ],
    ];
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'SDII-CRUD-Ajax' => '@common/templates/sdii-crud-ajax',
                    'SDII-CRUD' => '@common/templates/sdii-crud',
                ]
            ],
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'SDII-Model' => '@common/templates/sdii-model',
                ]
            ],
        ]
    ];

}

return $config;
