<?php
return [
    'language' => 'zh-CN',
    'sourceLanguage' => 'en-US',
    'timeZone' => 'PRC',
    'name' => 'YUNCMS',
    'bootstrap' => [
        'log', 'queue'
    ],
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
        'settings' => [
            'class' => 'yuncms\system\components\Settings',
            'frontCache' => 'cache'
        ],
        'queue' => [
            'class' => 'yii\queue\file\Queue',
            'path' => '@console/runtime/queue',
        ],
        'id98' => [
            'class' => 'xutl\id98\Id98',
            'apiKey' => '1234567890',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'myserver' => [
                    'class' => 'yuncms\user\clients\Yuncms',
                    'clientId' => '100000',
                    'clientSecret' => 'DEApVrgoByyGpmMhQFcuO7oYz5_oBrnUDEApVrgoByyGpmMhQFcuO7oYz5_oBrnU',
                    'authUrl' => 'http://api.dev.yuncms.net/auth/authorize',
                    'tokenUrl' => 'http://api.dev.yuncms.net/auth/token',
                ],
            ],
        ],
        'i18n' => require(__DIR__ . '/i18n.php'),

    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
];
