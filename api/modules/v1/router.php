<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return [
    //第一版
    [//用户
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/user',
        'except' => ['delete', 'create'],
        'extraPatterns' => [
            'GET search' => 'search',
            'GET me' => 'me',
            'GET extra' => 'extra',
            'PUT,PATCH,GET profile' => 'profile',
            'POST register' => 'register',
            'POST email-register' => 'email-register',
            'POST recovery' => 'recovery',
            'POST avatar' => 'avatar',
            'POST password' => 'password',
            'GET friendships' => 'friendships',
            'POST,DELETE follow' => 'follow',
            'GET,POST authentication' => 'authentication',
            'GET {id}/friends' => 'friends',
            'GET {id}/followers' => 'followers',
        ],
    ],

    [//私信
        'class' => 'yii\rest\UrlRule',
        'except' => ['delete', 'update'],
        'controller' => 'v1/message',
        'extraPatterns' => [
            'GET unread-messages' => 'unread-messages'
        ],
    ],

    [//通知
        'class' => 'yii\rest\UrlRule',
        'except' => ['delete', 'update', 'create'],
        'controller' => 'v1/notification',
        'extraPatterns' => [
            'POST read-all' => 'read-all',
            'GET,HEAD unread-notifications' => 'unread-notifications'
        ],
    ],

    [//话题
        'class' => 'yii\rest\UrlRule',
        'except' => ['delete', 'create', 'update'],
        'controller' => 'v1/tag',
        'extraPatterns' => [
            'GET search' => 'search',
        ],
    ],

    [//文章
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/article'],
        'extraPatterns' => [
            'GET,POST,DELETE {id}/collection' => 'collection',
            'POST {id}/support' => 'support',
            'GET,POST {id}/comments' => 'comment',
        ],
    ],

    [//圈子
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/group',
        'extraPatterns' => [
            'GET my' => 'my',
            'GET,PUT,PATCH,DELETE {id}/members/<user_id:\d+>' => 'member',
            'GET,POST {id}/members' => 'member',
            'GET search' => 'search',
            'GET joined' => 'joined',
            'POST {id}/join' => 'join',
        ],
    ],

    [//问答
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/question'],
        'extraPatterns' => [
            'GET my' => 'my',
            'GET collection' => 'collection',
            'GET,POST {id}/answers' => 'answer',
            'GET,POST {id}/comments' => 'comment',
            'POST {id}/support' => 'support',
            'POST,DELETE {id}/collection' => 'collection',
        ],
    ],

    [//头条
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/news',
        'extraPatterns' => [
            'POST {id}/support' => 'support',
        ],
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