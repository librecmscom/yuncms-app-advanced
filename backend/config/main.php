<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf_backend',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/security/login'],
            'identityClass' => 'yuncms\user\models\User',
            'identityCookie' => [
                'name' => '_identity_backend',
                'httpOnly' => true
            ],
        ],
        'frontUrlManager' => [
            'class' => 'yii\web\UrlManager',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'modules' => [
        'admin' => [
            'class' => 'yuncms\admin\Module'
        ],
        'system' => [
            'class' => 'yuncms\system\backend\Module'
        ],
        'attachment' => [
            'class' => 'yuncms\attachment\backend\Module'
        ],
        'article' => [
            'class' => 'yuncms\article\backend\Module',
        ],
        'comment' => [
            'class' => 'yuncms\comment\backend\Module',
        ],
        'authentication' => [
            'class' => 'yuncms\authentication\backend\Module',
        ],
        'user' => [
            'class' => 'yuncms\user\backend\Module'
        ],
        'oauth2' => [
            'class' => 'yuncms\oauth2\backend\Module'
        ],
        'link' => [
            'class' => 'yuncms\link\backend\Module'
        ],
        'note' => [
            'class' => 'yuncms\note\backend\Module'
        ],
        'question' => [
            'class' => 'yuncms\question\backend\Module'
        ],
    ],
    'params' => $params,
];
