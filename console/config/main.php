<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

//合并迁移命名空间
$migrationNamespaces = array_merge(
    require(__DIR__ . '/../../vendor/yuncms/migrations.php'),
    [
        'app\migrations',
    ]
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue','\yuncms\core\Bootstrap'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [//迁移配置
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@app/views/migration.php',
            'migrationPath' => null,// 完全禁用非命名空间迁移
            'migrationNamespaces' => $migrationNamespaces,
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
