<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return [
    'translations' => [
        'app*' => [
            'class' => 'yii\i18n\PhpMessageSource',
            //'basePath' => '@app/messages',
            'sourceLanguage' => 'en-GB',
            'fileMap' => [
                'app' => 'app.php',
                'app/error' => 'error.php',
            ],
        ],
        'admin' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/admin/messages',
        ],
        'system' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/system/messages',
        ],
        'attachment' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/system/messages',
        ],
        'user' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/user/messages',
        ],
        'message' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/message/messages',
        ],
        'coin' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/coin/messages',
        ],
        'doing' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/doing/messages',
        ],
        'support' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/support/messages',
        ],
        'attention' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/attention/messages',
        ],
        'collection' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/collection/messages',
        ],
        'notification' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/notification/messages',
        ],
        'credit' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yuncms/credit/messages',
        ],
    ]
];