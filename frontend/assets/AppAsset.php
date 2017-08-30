<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string the Web-accessible directory that contains the asset files in this bundle.
     */
    public $basePath = '@webroot';

    /**
     * @var string the base URL for the relative asset files listed in [[js]] and [[css]].
     */
    public $baseUrl = '@web';

    /**
     * @var array list of CSS files that this bundle contains. Each CSS file can be specified
     * in one of the three formats as explained in [[js]].
     */
    public $css = [
        'css/app.css',
    ];

    public $js = [
        'js/app.js',
    ];

    public $depends = [
        'frontend\assets\MainAsset',
    ];
}
