<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace frontend\assets;

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
        //'css/bootstrap-theme.css',
        'css/main.css',

    ];

    public $js = [
        'js/jquery.i18n.min.js',
        'js/main.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'xutl\fontawesome\Asset',
        'xutl\fmt\Asset',
        'yuncms\support\frontend\assets\SupportAsset',
        'yuncms\collection\frontend\assets\CollectionAsset',
        'yuncms\attention\frontend\assets\AttentionAsset',
        'yuncms\user\frontend\assets\UserAsset',
        'yuncms\message\frontend\assets\Asset',

    ];

    /**
     * @var string language to register translation file for
     */
    public $language;

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        if (Yii::$app->language != 'en-US') {
            $language = Yii::$app->language;
            $fallbackLanguage = substr(Yii::$app->language, 0, 2);
            if ($fallbackLanguage !== Yii::$app->language && !file_exists(Yii::getAlias($this->sourcePath . "js/i18n/{$language}.js"))) {
                $language = $fallbackLanguage;
            }
            array_unshift($this->js, "js/i18n/$language.js");
        }
        parent::registerAssetFiles($view);
    }
}