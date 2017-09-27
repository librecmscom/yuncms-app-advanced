<?php

namespace api\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;

/**
 * Class SiteController
 * @package api
 */
class SiteController extends Controller
{
    /**
     * default index
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        return '欢迎访问本站API接口。';
    }

    public function actionMethod(){
        return Yii::$app->request->method;
    }

    /**
     * Ping 心跳
     * @return string
     */
    public function actionPing()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        return 'Pong';
    }

    /**
     * 粗定位使用
     * @return array
     */
    public function actionLocation()
    {
        return [
            //IP
            'ip' => Yii::$app->request->userIP,
            //国家
            'country' => '',
            //大区
            'region' => '',
            //城市
            'city' => '',
            //地区
            'area' => '',
            //语言
            'language' => '',
            //货币
            'currency' => '',
            //isp 运营商
            'isp' => '',
        ];
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
