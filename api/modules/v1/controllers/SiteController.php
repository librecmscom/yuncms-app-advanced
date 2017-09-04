<?php
namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\Controller;

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
        return ['PONG'];
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
