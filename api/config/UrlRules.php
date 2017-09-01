<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return  [
    'GET /' => 'site/index',
    'GET ping' => 'site/ping',
    'GET ip' => 'site/ip',
    //第一版
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'v1/site',
        ]
    ],
];