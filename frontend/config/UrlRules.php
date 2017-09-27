<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return [
    '/' => 'site/index',
//    [
//        'class' => 'yii\web\UrlRule',
//        'name' => '首页',
//        'host'=>'aaa.dev.yuncms.net',
//        'suffix' => '.html',
//        'pattern' => '/index',
//        'route' => 'site/index',
//    ],


    //单页
    'about' => 'site/about',//关于
    'advertising' => 'site/adv',//广告
    'support' => 'site/support',//客户支持
    'help' => 'site/help',//帮助
    'contact' => 'site/contact',//联系我们
    'copyright' => 'site/copyright',//版权
    'logo' => 'site/logo',//logo
    'affiliate' => 'legal/affiliate',//联盟
    'privacy' => 'legal/privacy',//隐私
    'terms' => 'legal/terms',//服务条款

    //用户
    'u/<username:[\dA-Za-z]+>' => 'user/space/show',

    //笔记
    'notes/<page:\d+>' => 'note/note/index',
    'notes' => 'note/note/index',
    'notes/create' => 'note/note/create',
    'notes/<uuid:[\w+]+>/print' => 'note/note/print',
    'notes/<uuid:[\w+]+>/download' => 'note/note/download',
    //'note/<uuid:[\w+]+>' => 'note/note/view',

    //话题
    'topics' => 'topic/index',

    //问答
    'questions/<page:\d+>' => 'question/question/index',
    'questions' => 'question/question/index',
    'questions/tag' => 'question/question/tag',
    'questions/<id:\d+>' => 'question/question/view',

//    [//如果使用子域名部署，那么所有的规则都得像这样配置，不然跳转走了，跳转不回来了。因为检测到的host是当前域名的
//        'class' => 'yii\web\UrlRule',
//        'name' => '测试',
//        'host'=>'http://test.dev.yuncms.net',
//        'suffix' => '.html',
//        'pattern' => 'testSubDomain',
//        'route' => 'article/article/index',
//    ],

    //文章
    'articles/<page:\d+>' => 'article/article/index',
    'articles' => 'article/article/index',
    'articles/create' => 'article/article/create',
    'articles/tag' => 'article/article/tag',
    'articles/<id:[\w+]+>' => 'article/article/view',

    //友情链接
    'links' => 'link/default/index',

    //user
    'user/notice' => 'notification/notification/index',
    'user/space/<id:\d+>/coins' => 'coin/space/index',
    'user/space/<id:\d+>/followers' => 'attention/space/follower',
    'user/space/<id:\d+>/followed/<type:\w+>' => 'attention/space/attention',
    'user/space/<id:\d+>/collected/<type:\w+>' => 'collection/space/index',
];