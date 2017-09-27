<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use api\models\Profile;
use api\modules\v1\ActiveController;
use api\modules\v1\models\AvatarForm;
use api\modules\v1\models\User;

/**
 * 用户接口
 * @package api\modules\v1\controllers
 */
class UserController extends ActiveController
{

    public $modelClass = 'api\modules\v1\models\User';

    /**
     * @var string the scenario used for updating a model.
     * @see \yii\base\Model::scenarios()
     */
    public $updateScenario = 'update';

    /**
     * 定义操作
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create']);
        return $actions;
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
            'avatar' => ['POST'],
            'search' => ['GET'],
            'me' => ['GET'],
            'profile' => ['GET', 'PUT', 'PATCH'],
        ];
    }

    /**
     * 读取用户扩展数据
     * @return \yuncms\user\models\Extend
     */
    public function actionExtend()
    {
        /** @var \yuncms\user\models\User $user */
        $user = Yii::$app->user->identity;
        return $user->extend;
    }

    /**
     * 获取个人基本资料
     * @return array
     */
    public function actionMe()
    {
        /** @var \yuncms\user\models\User $user */
        $user = Yii::$app->user->identity;
        return [
            'id' => $user->id,
            'username' => $user->username,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'faceUrl' => $user->getAvatar()
        ];
    }

    /**
     * 获取个人扩展资料
     * @return Profile
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionProfile()
    {
        if (($model = Profile::findOne(['user_id' => Yii::$app->user->identity->getId()])) !== null) {
            if (!Yii::$app->request->isGet) {
                $model->load(Yii::$app->getRequest()->getBodyParams(), '');
                if ($model->save() === false && !$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
                }
            }
            return $model;
        } else {
            throw new NotFoundHttpException (Yii::t('yii', 'The requested page does not exist.'));
        }
    }

    /**
     * 上传头像
     * @return AvatarForm|bool
     * @throws ServerErrorHttpException
     */
    public function actionAvatar()
    {
        $model = new AvatarForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (($user = $model->save()) != false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(200);
            return $user;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * /**
     * 用户搜索
     * @param string $username
     * @return ActiveDataProvider
     */
    public function actionSearch($username)
    {
        $query = User::find()->where(['like', 'username', $username])->orWhere(['like', 'slug', $username]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

    /**
     * 检查当前用户的权限
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'update' && $model->id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
        } else if ($action === 'delete') {
            throw new ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
        }
    }
}