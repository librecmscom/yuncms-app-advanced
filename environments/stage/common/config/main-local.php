<?php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=' . getenv('YII_DB_HOST', true) . ';dbname=' . getenv('YII_DB_NAME'),
            'username' => getenv('YII_DB_USERNAME', true),
            'password' => getenv('YII_DB_PASSWORD', true),
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
                    'logFile' => '@runtime/logs/app-4xx.log',
                ],
                'email' => [
                    'class' => 'yii\log\EmailTarget',
                    'except' => ['yii\web\HttpException:404'],
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
