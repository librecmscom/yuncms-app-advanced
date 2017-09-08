<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return  [
    'GET /' => 'site/index',
    'GET ping' => 'site/ping',
    'GET location' => 'site/location',
    //第一版
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'v1/site',
        ]
    ],

    [//用户
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/user',
        'except' => ['delete', 'create'],
        'extraPatterns' => [
            'GET search' => 'search',
            'GET post' => 'register',
        ],
//        'ruleConfig' => [//额外的包含规则
//            'class' => 'yii\web\UrlRule',
//            'defaults' => [
//                'expand' => 'profile',
//            ]
//        ],
    ],
];