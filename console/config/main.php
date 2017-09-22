<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [//迁移配置
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@app/views/migration.php',
            'interactive' => 0,//自动应答
            // 完全禁用非命名空间迁移
            'migrationPath' => null,
            'migrationNamespaces' => [//命名空间
                'app\migrations',
                'yuncms\admin\migrations',
                'yuncms\tag\migrations',
                'yuncms\user\migrations',
                'yuncms\question\migrations',
                'yuncms\comment\migrations',
                'yuncms\attachment\migrations',
                'yuncms\article\migrations',
                'yuncms\note\migrations',
                'yuncms\message\migrations',
                'yuncms\oauth2\migrations',
                'yuncms\authentication\migrations',
                'yuncms\notification\migrations',
            ],
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
