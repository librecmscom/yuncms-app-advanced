<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
return [
    // use bootstrap css from CDN
    'yii\bootstrap\BootstrapAsset' => [
        'sourcePath' => null, // do not use file from our server
        'css' => [
            '//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css']
    ],
    // use bootstrap js from CDN
    'yii\bootstrap\BootstrapPluginAsset' => [
        'sourcePath' => null, // do not use file from our server
        'js' => [
            '//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js']
    ],
    // use jquery from CDN
    'yii\web\JqueryAsset' => [
        'sourcePath' => null, // do not publish the bundle
        'js' => [
            '//cdn.bootcss.com/jquery/2.2.4/jquery.min.js',
        ]
    ],
    // use jquery input mask from CDN
    'yii\widgets\MaskedInputAsset' => [
        'sourcePath' => null, // do not publish the bundle
        'js' => [
            '//cdn.bootcss.com/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js',
        ]
    ],
    // use jquery ui from CDN
    'yii\jui\JuiAsset' => [
        'sourcePath' => null, // do not publish the bundle
        'css' => [
            '//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.css'
        ],
        'js' => [
            '//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js'
        ],
    ],
    // use font-awesome from CDN
    'xutl\fontawesome\Asset' => [
        'sourcePath' => null, // do not publish the bundle
        'css' => [
            '//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css',
        ]
    ],
    // use cropper from CDN
    'xutl\cropper\CropperAsset' => [
        'sourcePath' => null, // do not publish the bundle
        'css' => [
            '//cdn.bootcss.com/cropper/2.3.4/cropper.min.css',
        ],
        'js' => [
            '//cdn.bootcss.com/cropper/2.3.4/cropper.min.js'
        ]
    ],
];