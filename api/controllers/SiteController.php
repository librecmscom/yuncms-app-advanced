<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * default index
     * @return array
     */
    public function actionIndex()
    {
        return [
            '欢迎访问本站API接口。'
        ];
    }

    /**
     * Ping
     * @return array
     */
    public function actionPing()
    {
        return ['ok'];
    }

    /**
     * client ip
     * @return array
     */
    public function actionIp()
    {
        return [Yii::$app->request->userIP];
    }

}
