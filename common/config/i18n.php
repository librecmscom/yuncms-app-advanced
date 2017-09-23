<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
//合并语言包配置
$translations = array_merge(
    require(__DIR__ . '/../../vendor/yuncms/i18n.php'),
    [
        'app*' => [
            'class' => 'yii\i18n\PhpMessageSource',
            //'basePath' => '@app/messages',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'app' => 'app.php',
                'app/error' => 'error.php',
            ],
        ],
    ]
);
return [
    'translations' => $translations,
];