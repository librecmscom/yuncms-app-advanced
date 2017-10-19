<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return [
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
        'controller' => ['v1/article'],
        'extraPatterns' => [
            'POST,DELETE <id:\d+>/collection' => 'collection',
            'POST <id:\d+>/support' => 'support',
        ],
    ],

    [//问答
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/question'],
        'extraPatterns' => [
            'POST,DELETE <id:\d+>/collection' => 'collection',
            'GET,POST <id:\d+>/answers' => 'answer',
        ],
    ],

    [//圈子
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/group',
        'extraPatterns' => [
            'GET my' => 'my',
            'GET,PUT,PATCH,DELETE <id:\d+>/members/<user_id:\d+>' => 'member',
            'GET,POST <id:\d+>/members' => 'member',
            'GET search' => 'search',
            'GET joined' => 'joined',
            'POST <id:\d+>/join' => 'join',
        ],
    ],

    [//用户
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/user',
        'except' => ['delete', 'create'],
        'extraPatterns' => [
            'GET search' => 'search',
            'GET me' => 'me',
            'GET extend' => 'extend',
            'PUT,PATCH,GET profile' => 'profile',
            'POST register' => 'register',
            'POST avatar' => 'avatar',
            'PUT,PATCH,GET,DELETE <id:\d+>/educations/<eid:\d+>' => 'education',
            'GET,POST <id:\d+>/educations' => 'education',
            'PUT,PATCH,GET,DELETE <id:\d+>/careers/<eid:\d+>' => 'career',
            'GET,POST <id:\d+>/careers' => 'career',
        ],
//        'ruleConfig' => [//额外的包含规则
//            'class' => 'yii\web\UrlRule',
//            'defaults' => [
//                'expand' => 'profile',
//            ]
//        ],
    ],

    [//支付
        'class' => 'yii\rest\UrlRule',
        'except' => ['delete', 'update'],
        'controller' => 'v1/payment',
        'extraPatterns' => [
            'GET search' => 'search',
        ],
    ],
];