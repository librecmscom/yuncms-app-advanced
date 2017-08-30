<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yuncms\oauth2\frontend\models\LoginForm;

/**
 * OAuth2 认证
 * @property bool $isOauthRequest 是否是OAuth2请求
 * @method finishAuthorization
 * @package api\controllers
 */
class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'oauth2Auth' => [
                'class' => 'yuncms\oauth2\filters\Authorize',
                'only' => ['authorize'],
            ],
        ];
    }

    public function actions()
    {
        return [
            /**
             * Returns an access token.
             */
            'token' => [
                'class' => 'yuncms\oauth2\actions\Token',
            ],
        ];
    }

    /**
     * Display login form, signup or something else.
     * AuthClients such as Google also may be used
     */
    public function actionAuthorize()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($this->isOauthRequest) {
                $this->finishAuthorization();
            } else {
                return $this->goBack();
            }
        } else {
            $this->layout = false;
            return $this->render('authorize', [
                'model' => $model,
            ]);
        }
    }
}