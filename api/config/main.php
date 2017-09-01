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
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
                'application/xml' => 'yuncms\system\web\XmlParser',
                'text/xml' => 'yuncms\system\web\XmlParser'
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                /** @var \yii\web\Response $response */
                $response = $event->sender;
                $headers = $response->getHeaders();
                //$headers->set('Access-Control-Allow-Origin', '*');
                //$headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, OPTIONS');
                //$headers->set('Access-Control-Allow-Headers', 'DNT,access-token,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type');
            },
        ],
        'user' => [
            'identityClass' => 'yuncms\user\models\User',
            'enableSession' => false,
            'loginUrl' => null,
            'enableAutoLogin' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/UrlRules.php'),
        ],
    ],
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => $params,
];
