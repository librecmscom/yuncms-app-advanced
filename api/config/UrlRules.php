<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return [
    'GET /' => 'site/index',
    'GET ping' => 'site/ping',
    'GET location' => 'site/location',

    //第一版
    [//公共接口
        'class' => 'yii\rest\UrlRule',
        'except' => ['delete', 'create', 'update'],
        'controller' => ['v1/category', 'v1/language', 'v1/area', 'v1/country', 'v1/currency']
    ],
    [//话题
        'class' => 'yii\rest\UrlRule',
        'except' => ['delete', 'create', 'update'],
        'controller' => 'v1/topic',
        'extraPatterns' => [
            'GET search' => 'search',
        ],
    ],
    [//文章
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'v1/article',
        ]
    ],
    [//用户
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/user',
        'except' => ['delete', 'create'],
        'extraPatterns' => [
            'GET search' => 'search',
            'POST avatar' => 'avatar',
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