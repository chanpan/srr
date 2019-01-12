<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

$config = [
    'id' => 'app-frontend',
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'timeZone' => 'Asia/Bangkok',
    'language' => 'th-TH',
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
                // enter optional module parameters below - only if you need to  
                // use your own export download action or custom translation 
                // message source
                // 'downloadAction' => 'gridview/export/download',
                // 'i18n' => []
            ],
        'sections' => [
            'class' => 'frontend\modules\sections\Module',
        ],
        'account' => [
            'class' => 'frontend\modules\account\Module',
        ],
        'noty' => [
            'class' => 'lo\modules\noty\Module',
        ],
        'knowledges' => [
            'class' => 'frontend\modules\knowledges\Module',
        ],
        'museum' => [
            'class' => 'frontend\modules\museum\Module',
        ],
    ],
    'components' => [
        'meta' => [
            'class' => 'frontend\components\MetaComponent',
        ],//seo config
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages', // if advanced application, set @frontend/messages
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
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@frontend/views' => '@frontend/themes/adminlte'
//                ],
//            ],
//       ],
       'view' => [
            'theme' => [
                'pathMap' => [
                   '@frontend/views' => '@frontend/themes/siriraj2'
                ],
            ],
       ],
        'request' => [
//            'baseUrl' => '',
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'loginUrl'=>['/account/sign-in/login'],
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'app-frontend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'cache' => require __DIR__ . '/_cache.php',
    ],
    
    'as beforeAction' => [
        'class' => 'common\behaviors\LastActionBehavior',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    
    $config['bootstrap']['log'] = [
        'class' => 'common\components\LanguageSelector',
        'supportedLanguages' => ['en-US', 'th-TH'], //กำหนดรายการภาษาที่ support หรือใช้ได้
    ];
//    $config['bootstrap']['log'][] = 'frontend\components\AppComponent';
    //print_r($config['bootstrap']['log']);exit();
    
   // var_dump($config);
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*'],
    ];
}

if (YII_ENV_PROD) {
    // maintenance mode
    $config['bootstrap'] = ['maintenance'];
    $config['components']['maintenance'] = [
        'class' => 'common\components\maintenance\Maintenance',
        'enabled' => env('MAINTENANCE_MODE'),
        'route' => 'maintenance/index',
        'message' => env('MAINTENANCE_MODE_MESSAGE'),
        // year-month-day hour:minute:second
        'time' => env('MAINTENANCE_MODE_TIME'), // время окончания работ
    ];
}

return $config;
