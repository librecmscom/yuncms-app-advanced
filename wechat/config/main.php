<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$urlRule = require(__DIR__ . '/url-rule.php');

return [
    'id' => 'app-wechat',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',],
    'controllerNamespace' => 'wechat\controllers',
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
                'application/xml' => 'yuncms\system\web\XmlParser',
                'text/xml' => 'yuncms\system\web\XmlParser'
            ]
        ],
        'user' => [
            'identityClass' => 'yuncms\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'wechat',
            'cookieParams' => [
                'lifetime' => 1440,
                //'secure' => true,
                'httponly' => true,
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $urlRule,
        ],
        'i18n' => [
            'translations' => [
                'wechat' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@wechat/messages',
                ],
            ]
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/views',
                'baseUrl' => '@web',
                'pathMap' => [
                    '@yuncms/user/wechat/views' => [
                        '@app/views/user',
                    ],
                ],
            ],
        ],
        'wechat' => [
            'class' => 'xutl\wechat\Wechat',
            'appId' => 'wx60e97311b01803c7',
            'appSecret' => 'a0458251ffe25579192d9a3313fb9076',
        ],
    ],
    'modules' => [
        'user' => [//用户模块
            'class' => 'yuncms\user\wechat\Module',
        ],
    ],
    'params' => $params,
];
