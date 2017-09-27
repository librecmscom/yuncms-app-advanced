<?php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
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
