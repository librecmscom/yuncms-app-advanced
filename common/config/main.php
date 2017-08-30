<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
            'tablePrefix' => 'yun_',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-M-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'myserver' => [
                    'class' => 'yuncms\user\clients\Yuncms',
                    'clientId' => '100000',
                    'clientSecret' => 'DEApVrgoByyGpmMhQFcuO7oYz5_oBrnUDEApVrgoByyGpmMhQFcuO7oYz5_oBrnU',
                    'tokenUrl' => 'http://127.0.0.1/yuncms-app-advanced/api/web/auth/authorize',
                    'authUrl' => 'http://127.0.0.1/yuncms-app-advanced/api/web/auth/index',
                    'apiBaseUrl' => 'http://127.0.0.1/yuncms-app-advanced/api/web/api',
                ],
            ],
        ],
        'i18n' => require(__DIR__ . '/i18n.php'),
        'settings' => [
            'class' => 'yuncms\system\components\Settings',
            'frontCache' => 'cache'
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
];
