<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$modules = array_merge(
    require(__DIR__ . '/../../vendor/yuncms/backend.php'),
    require(__DIR__ . '/../../common/config/modules.php'),
    require(__DIR__ . '/../../common/config/modules-local.php'),
    require(__DIR__ . '/modules.php'),
    require(__DIR__ . '/modules-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'default' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf_backend',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/security/login'],
            'identityClass' => 'yuncms\admin\models\Admin',
            'identityCookie' => [
                'name' => '_identity_backend',
                'httpOnly' => true
            ],
        ],
        'authManager' => [
            'class' => 'yuncms\admin\components\RbacManager',
            'cache' => 'cache',
        ],
        'frontUrlManager' => [
            'class' => 'yii\web\UrlManager',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => '/admin/security/login',
                'logout' => '/admin/security/logout',
            ],
        ],
        */
    ],
    'modules' => $modules,
    'params' => $params,
];
