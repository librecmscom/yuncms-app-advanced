<?php

namespace api\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\base\Exception;
use yii\web\HttpException;
use yii\base\ErrorException;

/**
 * Class SiteController
 * @package api
 */
class SiteController extends Controller
{
    /**
     * Display welcome
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        return 'Welcome to the API interface.';
    }

    /**
     * Test http request
     * @return array
     */
    public function actionTest()
    {
        return [
            'method' => Yii::$app->request->method,
            'bin' => 0b11,
            //'POST' => Yii::$app->request->post,
        ];
    }

    /**
     * Display Pong
     * @return string
     */
    public function actionPing()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        return 'Pong';
    }

    /**
     * Display Location
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
     * Display error action
     * @return array
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        $array = [
            "name" => ($exception instanceof Exception || $exception instanceof ErrorException) ? $exception->getName() : 'Exception',
            "message" => $exception->getMessage(),
            "code" => $exception->getCode(),
            "status" => $exception->getCode(),
        ];
        if ($exception instanceof HttpException) {
            $array['status'] = $exception->statusCode;
        }
        return $array;
    }
}
