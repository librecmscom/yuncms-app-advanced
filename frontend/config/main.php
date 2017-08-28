<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'yuncms\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'assetManager' => [//前端资源压缩
            'linkAssets' => PHP_OS == 'WINNT' ? false : true,
            'appendTimestamp' => true,
            'bundles' => [
                // use bootstrap css from CDN
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null, // do not use file from our server
                    'css' => [
                        '//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css']
                ],
                // use bootstrap js from CDN
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null, // do not use file from our server
                    'js' => [
                        '//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js']
                ],
                // use jquery from CDN
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null, // do not publish the bundle
                    'js' => [
                        '//cdn.bootcss.com/jquery/2.2.4/jquery.min.js',
                    ]
                ],
                'yii\widgets\MaskedInputAsset' => [
                    'sourcePath' => null, // do not publish the bundle
                    'js' => [
                        '//cdn.bootcss.com/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js',
                    ]
                ],
                'yii\jui\JuiAsset' => [
                    'sourcePath' => null, // do not publish the bundle
                    'css' => [
                        '//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.css'
                    ],
                    'js' => [
                        '//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js'
                    ],
                ],
                'xutl\fontawesome\Asset' => [
                    'sourcePath' => null, // do not publish the bundle
                    'css' => [
                        '//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css',
                    ]
                ],

                'xutl\cropper\CropperAsset' => [
                    'sourcePath' => null, // do not publish the bundle
                    'css' => [
                        '//cdn.bootcss.com/cropper/2.3.4/cropper.min.css',
                    ],
                    'js' => [
                        '//cdn.bootcss.com/cropper/2.3.4/cropper.min.js'
                    ]
                ],
            ],
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
    'params' => $params,
];
