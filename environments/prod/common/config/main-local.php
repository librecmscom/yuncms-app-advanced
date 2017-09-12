<?php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            //必须开启，不然查询会额外多消耗 30-100ms
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'enableQueryCache' => true,
            //分布式系统这里可以设置一个 本机cache,不适用集群cache,速度更好。
            //'queryCache' => 'cache',
            'queryCacheDuration' => 3600
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'categories' => [
                        'yii\web\HttpException:404',
                        'yii\web\ForbiddenHttpException:403',
                        'yii\web\UnauthorizedHttpException:401',
                    ],
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/api-4xx.log',
                ],
                'email' => [
                    'class' => 'yii\log\EmailTarget',
                    'except' => ['yii\web\HttpException:404'],
                    'levels' => ['error', 'warning'],
                    'message' => ['to' => 'admin@example.com'],
                ],
                'default' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/api.log',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                        'yii\web\ForbiddenHttpException:403',
                        'yii\web\UnauthorizedHttpException:401',
                    ],
                ],
            ],
        ],
    ],
];
