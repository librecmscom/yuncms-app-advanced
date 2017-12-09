<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace wechat\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MainAsset extends AssetBundle
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
        'css/main.css',
    ];

    public $js = [
        'js/main.js',
    ];

    public $depends = [
        'xutl\wechat\WechatAsset'
    ];
}