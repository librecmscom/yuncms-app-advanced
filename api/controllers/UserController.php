<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;
use api\models\UserSettingsForm;
use api\models\UserRecoveryForm;
use api\models\UserRegistrationForm;
use api\models\UserEmailRegistrationForm;
use api\models\UserMobileRegistrationForm;
use api\models\UserSocialBindMobileForm;

/**
 * 用户接口
 * @package api\modules\v1\controllers
 */
class UserController extends Controller
{
    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * 初始化 API 控制器验证
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => 'yuncms\oauth2\filters\auth\TokenAuth',
        ];
        return $behaviors;
    }

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'register' => ['POST'],
            'mobile-register' => ['POST'],
            'email-register' => ['POST'],
            'password' => ['POST'],
            'recovery' => ['POST'],
        ];
    }

    /**
     * @return UserRegistrationForm|false|\yuncms\user\models\User
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRegister()
    {
        $model = new UserRegistrationForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (($user = $model->register()) != false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($user->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            return $user;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 注册用户
     * @return UserMobileRegistrationForm|false|\yuncms\user\models\User
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionMobileRegister()
    {
        $model = new UserMobileRegistrationForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (($user = $model->register()) != false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($user->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            return $user;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 注册用户
     * @return UserEmailRegistrationForm|\yuncms\user\models\User
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEmailRegister()
    {
        $model = new UserEmailRegistrationForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (($user = $model->register()) != false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($user->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            return $user;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 修改密码
     * @return UserSettingsForm
     * @throws ServerErrorHttpException
     */
    public function actionPassword()
    {
        $model = new UserSettingsForm();
        $model->load(Yii::$app->request->post(), '');
        if ($model->save()) {
            Yii::$app->getResponse()->setStatusCode(200);
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 重置密码
     * @return UserRecoveryForm
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRecovery()
    {
        $model = new UserRecoveryForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->resetPassword()) {
            Yii::$app->getResponse()->setStatusCode(200);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 绑定手机号
     * @return UserSocialBindMobileForm
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionBindMobile()
    {
        $model = new UserSocialBindMobileForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->bingMobile()) {
            Yii::$app->getResponse()->setStatusCode(200);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}