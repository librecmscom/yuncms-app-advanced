<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace wechat\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class SiteController
 * @package wechat\controllers
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionNotice()
    {
        $notice = Yii::$app->notice;
        $userId = 'o7rt3wbtY9ETGP2W2yVQ5MAPW5rI';
        $templateId = 'I-9v9pgL_1WcnB7nzMtSYkJT1IH4-8mWaRzj-oZpOy4';
        $url = 'https://www.openedu.tv';
        $data = [
            "first" => "您好，您已在电脑端成功登录！",
            "keyword1" => "XCR",
            "keyword2" => "就刚才",
            "remark" => "感谢使用，请注意账号安全。",
        ];
        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        var_dump($result);
// {
//      "errcode":0,
//      "errmsg":"ok",
//      "msgid":200228332
//  }
    }
}