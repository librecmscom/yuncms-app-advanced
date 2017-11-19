<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use api\modules\v1\models\User;
use api\modules\v1\ActiveController;
use api\modules\v1\models\AvatarForm;
use api\modules\v1\models\Authentication;
use api\modules\v1\models\RegistrationForm;
use yuncms\user\models\Career;
use yuncms\user\models\Education;
use yuncms\user\models\Profile;

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
            'authentication' => ['GET', 'POST', 'PUT', 'PATCH'],
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
            'isAuthentication' => Authentication::isAuthentication($user->id),
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
     * 实名认证
     * @param int $id
     * @return null|Education|static|object
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionAuthentication($id)
    {
        $user = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if (($model = Authentication::findOne(['user_id' => $user->id])) == null) {
                $model = new Authentication();
                $model->scenario = Authentication::SCENARIO_CREATE;
            } else {
                $model->scenario = Authentication::SCENARIO_UPDATE;
            }
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if (($model->save()) != false) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            return $model;
        } else if (Yii::$app->request->isGet) {
            if (($model = Authentication::findOne(['user_id' => $id])) != null) {
                return $model;
            }
            throw new NotFoundHttpException("Object not found: $id");
        }
        throw new MethodNotAllowedHttpException();
    }

    /**
     * 教育经历 CURD
     * @param int $id
     * @param int $eid
     * @return null|Education|static|object
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionEducation($id, $eid = null)
    {
        $user = $this->findModel($id);
        if (Yii::$app->request->isPost) {//发布
            $model = new Education();
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if (($model->save()) != false) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            return $model;
        } else if (Yii::$app->request->isGet) {
            if (!empty($eid)) {
                if (($model = Education::findOne(['user_id' => Yii::$app->user->id, 'id' => $eid])) != null) {
                    return $model;
                } else {
                    throw new NotFoundHttpException("Object not found: $id");
                }
            } else {
                return Yii::createObject([
                    'class' => ActiveDataProvider::className(),
                    'query' => $user->getEducations(),
                ]);
            }
        } else if ((Yii::$app->request->isPut || Yii::$app->request->isPatch) && !empty($eid)) {
            if (($model = Education::findOne(['user_id' => Yii::$app->user->id, 'id' => $eid])) != null) {
                $model->load(Yii::$app->getRequest()->getBodyParams(), '');
                if (($model->save()) != false) {
                    $response = Yii::$app->getResponse();
                    $response->setStatusCode(200);
                    return $model;
                } elseif (!$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
                return $model;
            } else {
                throw new NotFoundHttpException("Object not found: $eid");
            }
        } else if (Yii::$app->request->isDelete && !empty($eid)) {
            if (($model = Education::findOne(['user_id' => Yii::$app->user->id, 'id' => $eid])) != null) {
                $model->load(Yii::$app->getRequest()->getBodyParams(), '');
                if (($model->delete()) != false) {
                    $response = Yii::$app->getResponse();
                    $response->setStatusCode(204);
                } elseif (!$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
                return $model;
            } else {
                throw new NotFoundHttpException("Object not found: $eid");
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    /**
     * 职业经历 CURD
     * @param int $id
     * @param int $cid
     * @return null|Education|static|object
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionCareer($id, $cid = null)
    {
        $user = $this->findModel($id);
        if (Yii::$app->request->isPost) {//发布
            $model = new Career();
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if (($model->save()) != false) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            return $model;
        } else if (Yii::$app->request->isGet) {
            if (!empty($cid)) {
                if (($model = Career::findOne(['user_id' => Yii::$app->user->id, 'id' => $cid])) != null) {
                    return $model;
                } else {
                    throw new NotFoundHttpException("Object not found: $id");
                }
            } else {
                return Yii::createObject([
                    'class' => ActiveDataProvider::className(),
                    'query' => $user->getCareers(),
                ]);
            }
        } else if ((Yii::$app->request->isPut || Yii::$app->request->isPatch) && !empty($cid)) {
            if (($model = Education::findOne(['user_id' => Yii::$app->user->id, 'id' => $cid])) != null) {
                $model->load(Yii::$app->getRequest()->getBodyParams(), '');
                if (($model->save()) != false) {
                    $response = Yii::$app->getResponse();
                    $response->setStatusCode(200);
                    return $model;
                } elseif (!$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
                return $model;
            } else {
                throw new NotFoundHttpException("Object not found: $cid");
            }
        } else if (Yii::$app->request->isDelete && !empty($cid)) {
            if (($model = Education::findOne(['user_id' => Yii::$app->user->id, 'id' => $cid])) != null) {
                $model->load(Yii::$app->getRequest()->getBodyParams(), '');
                if (($model->delete()) != false) {
                    $response = Yii::$app->getResponse();
                    $response->setStatusCode(204);
                } elseif (!$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
                return $model;
            } else {
                throw new NotFoundHttpException("Object not found: $cid");
            }
        }
        throw new MethodNotAllowedHttpException();
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
     * 用户搜索
     * @param string $username
     * @return ActiveDataProvider
     */
    public function actionSearch($username)
    {
        $query = User::find()->where(['like', 'username', $username])->orWhere(['like', 'username', $username]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

    /**
     * 注册用户
     * @return RegistrationForm|false|\yuncms\user\models\User
     * @throws ServerErrorHttpException
     */
    public function actionRegister()
    {
        $model = new RegistrationForm();
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
     * 获取用户
     * @param int $id
     * @return User
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if (($model = User::findOne($id)) != null) {
            return $model;
        } else {
            throw new NotFoundHttpException("Object not found: $id");
        }
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