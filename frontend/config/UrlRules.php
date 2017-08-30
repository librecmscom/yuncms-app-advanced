<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return [
    '/' => 'site/index',

    //单页
    'about' => 'site/about',//关于
    'advertising' => 'site/adv',//广告
    'support' => 'site/support',//客户支持
    'help' => 'site/help',//帮助
    'contact' => 'site/contact',//联系我们
    'copyright' => 'site/copyright',//版权
    'logo' => 'site/logo',//log
    'affiliate' => 'legal/affiliate',//联盟
    'privacy' => 'legal/privacy',//隐私
    'terms' => 'legal/terms',//服务条款

    //用户
    'u/<slug:[\dA-Za-z]+>' => 'user/space/show',

    //笔记
    'notes/<page:\d+>' => 'note/note/index',
    'notes' => 'note/note/index',
    'note/create' => 'note/note/create',
    'note/print/<uuid:[\w+]+>' => 'note/note/print',
    'note/download/<uuid:[\w+]+>' => 'note/note/download',
    'note/<uuid:[\w+]+>' => 'note/note/view',

    //标签
    'topics' => 'tag/index',

    //问答
    'questions/<page:\d+>' => 'question/question/index',
    'questions' => 'question/question/index',
    'question/tag' => 'question/question/tag',
    'question/<id:\d+>' => 'question/question/view',

    //文章
    'articles/<page:\d+>' => 'article/article/index',
    'articles' => 'article/article/index',
    'article/create' => 'article/article/create',
    'article/tag' => 'article/article/tag',
    'article/<key:[\w+]+>' => 'article/article/view',

    //友情链接
    'links' => 'link/default/index',

    //user
    'user/notice' => 'notification/notification/index',
    'user/space/<id:\d+>/coins' => 'coin/space/index',
    'user/space/<id:\d+>/followers' => 'attention/space/follower',
    'user/space/<id:\d+>/followed/<type:\w+>' => 'attention/space/attention',
    'user/space/<id:\d+>/collected/<type:\w+>' => 'collection/space/index',
];