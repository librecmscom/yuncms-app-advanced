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
            'POST,DELETE {id}/collection' => 'collection',
            'POST {id}/support' => 'support',
        ],
    ],

    [//问答
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/question'],
        'extraPatterns' => [
            'POST,DELETE {id}/collection' => 'collection',
            'GET,POST {id}/answers' => 'answer',
        ],
    ],

    [//圈子
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/group',
        'extraPatterns' => [
            'GET my' => 'my',
            'GET,PUT,PATCH,DELETE {id}/members/<user_id:\d+>' => 'member',
            'GET,POST <id:\d+>/members' => 'member',
            'GET search' => 'search',
            'GET joined' => 'joined',
            'POST {id}/join' => 'join',
        ],
    ],


    [//头条
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/news',
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

            'PUT,PATCH,GET,DELETE {id}/educations/<eid:\d+>' => 'education',
            'GET,POST {id}/educations' => 'education',

            'PUT,PATCH,GET,DELETE <id:\d+>/careers/<eid:\d+>' => 'career',
            'GET,POST {id}/careers' => 'career',

            'GET,POST {id}/authentication' => 'authentication',
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