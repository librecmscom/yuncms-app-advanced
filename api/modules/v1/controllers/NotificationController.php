<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use api\modules\v1\Controller;
use api\modules\v1\models\Notification;


/**
 * 系统通知
 * @package api\modules\v1\controllers
 */
class NotificationController extends Controller
{

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'read-all' => ['POST'],
            'unread-notifications' => ['GET', 'HEAD'],
        ];
    }

    /**
     * 显示通知首页
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $query = Notification::find()->where(['to_user_id' => Yii::$app->user->getId()]);
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * 标记通知未已读
     * @return void
     */
    public function actionReadAll()
    {
        Notification::setReadAll(Yii::$app->user->getId());
        Yii::$app->getResponse()->setStatusCode(200);
    }

    /**
     * 未读通知数目
     * @return array
     * @throws \Exception|\Throwable
     */
    public function actionUnreadNotifications()
    {
        $total = Notification::getDb()->cache(function ($db) {
            return Notification::find()->where(['to_user_id' => Yii::$app->user->id, 'status' => Notification::STATUS_UNREAD])->count();
        }, 60);
        return ['total' => $total];
    }
}