<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$modules = array_merge(
    require(__DIR__ . '/../../vendor/yuncms/frontend.php'),
    require(__DIR__ . '/../../common/config/modules.php'),
    require(__DIR__ . '/../../common/config/modules-local.php'),
    require(__DIR__ . '/modules.php'),
    require(__DIR__ . '/modules-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
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
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'yuncms\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [//前端资源压缩
            'linkAssets' => PHP_OS == 'WINNT' ? false : true,
            'appendTimestamp' => true,
            //'bundles' => require(__DIR__ . '/assets.php'),//打包编译本地资源,包含CDN资源
            'bundles' => require(__DIR__ . '/CDNBundles.php'),//仅定义CDN资源
        ],
        'view' => [
            'theme' => require(__DIR__ . '/theme.php'),
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/UrlRules.php'),
        ],
    ],
    'modules' => $modules,
    'params' => $params,
];
