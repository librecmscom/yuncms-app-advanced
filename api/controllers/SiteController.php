<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;

/**
 * Class SiteController
 * @package api
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

    /**
     * error action
     * @return array
     */
    public function actionError()
    {
        return [
            "name" => "Not Found",
            "message" => "The requested resources does not exist.",
            "code" => 0,
            "status" => 404,
        ];
    }
}
