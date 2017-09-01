<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace frontend\components;

use Yii;
use yii\web\Cookie;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package frontend
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param \yii\web\Application $app the application currently running
     */
    public function bootstrap($app)
    {
        //检查站点关闭状态
        if (Yii::$app->settings->get('close', 'system')) {
            $app->catchAll = [
                'site/offline',
                'reason' => Yii::$app->settings->get('closeReason', 'system')
            ];
        }

        //注册关键词和描述
        Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->settings->get('description', 'system')]);
        Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->settings->get('keywords', 'system')]);

        $app->view->params['title'] = Yii::$app->settings->get('title', 'system');
        $app->view->params['copyright'] = Yii::$app->settings->get('copyright', 'system');
        $app->view->params['analysisCode'] = Yii::$app->settings->get('analysisCode', 'system');

        //自动检测语言
        if (($language = Yii::$app->request->getQueryParam('language')) !== null) {
            $app->language = $language;
            Yii::$app->response->cookies->add(new Cookie(['name' => 'language', 'value' => $language]));
        } else if (($cookie = Yii::$app->request->cookies->get('language')) !== null) {
            $app->language = $cookie->value;
        } else if (($language = Yii::$app->request->getPreferredLanguage()) !== null) {
            $app->language = $language;
        }
    }
}