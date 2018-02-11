<?php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=' . getenv('YII_DB_HOST', true) . ';dbname=' . getenv('YII_DB_NAME'),
            'username' => getenv('YII_DB_USERNAME', true),
            'password' => getenv('YII_DB_PASSWORD', true),
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
            'enableSwiftMailerLogging' => true,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
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
                    'logFile' => '@runtime/logs/app-4xx.log',
                ],
                'smtp' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/app-smtp.log',
                    'categories' => [
                        'yii\swiftmailer\Logger::add'
                    ],
                ],
                'email' => [
                    'class' => 'yii\log\EmailTarget',
                    'except' => [
                        'yii\web\HttpException:404',
                        'yii\web\ForbiddenHttpException:403',
                        'yii\web\UnauthorizedHttpException:401',
                    ],
                    'levels' => ['error', 'warning'],
                    'message' => ['to' => 'admin@example.com'],
                ],
                'default' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/app.log',
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
