<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', dirname(__DIR__) . '/web');
Yii::setAlias('@web', '/');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar bin/compiler.jar --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar bin/yuicompressor-2.4.2.jar --type css {from} -o {to}',
    // The list of asset bundles to compress:
    'bundles' => [
        'yii\web\YiiAsset',
        'yii\captcha\CaptchaAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\grid\GridViewAsset',
        'xutl\fmt\Asset',
        'yuncms\user\frontend\assets\UserAsset',
        'yuncms\user\frontend\assets\CropperAsset',

        'frontend\assets\AppAsset',//当前依赖

        //以下是 CDN资源，如果不写，那么生成的文件就不包含CDN资源定义。
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset',
        'yii\widgets\MaskedInputAsset',
        'yii\jui\JuiAsset',
        'xutl\fontawesome\Asset',
        'xutl\cropper\CropperAsset',
        //'xutl\select2\Select2Asset',
        'xutl\bootstrap\filestyle\FilestyleAsset'
    ],
    // Asset bundle for compression output:
    'targets' => [
        'vendor' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'vendor-{hash}.js',
            'css' => 'vendor-{hash}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'bundles' => require(__DIR__ . '/CDNBundles.php'),
    ],
];