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
