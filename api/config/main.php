<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
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
            'parsers' => [
                'multipart/form-data' => 'yii\web\MultipartFormDataParser',
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
                'application/xml' => 'yuncms\system\web\XmlParser',
                'text/xml' => 'yuncms\system\web\XmlParser'
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'user' => [
            'identityClass' => 'yuncms\user\models\User',
            'enableSession' => false,
            'loginUrl' => null,
            'enableAutoLogin' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            // 'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/UrlRules.php'),
        ],
    ],
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => $params,
];
