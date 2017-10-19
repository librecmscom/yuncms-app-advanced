<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use api\modules\v1\ActiveController;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yuncms\collection\models\Collection;
use yuncms\question\models\Answer;
use yuncms\question\models\Question;

/**
 * Class QuestionController
 * @package api\modules\v1\controllers
 */
class QuestionController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Question';

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'collection' => ['POST', 'DELETE'],
            'answer' => ['GET', 'POST'],
        ];
    }

    /**
     * 问题收藏
     * @param int $id
     * @return void
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionCollection($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isDelete) {
            $userCollect = Collection::findOne(['user_id' => Yii::$app->user->id, 'model' => get_class($model), 'model_id' => $id]);
            if ($userCollect) {
                $userCollect->delete();
                $model->updateCounters(['collections' => -1]);
                Yii::$app->getResponse()->setStatusCode(204);
                return;
            } else {
                throw new NotFoundHttpException("Object not found.");
            }
        } else if (Yii::$app->request->isPost) {
            $userCollect = Collection::findOne(['user_id' => Yii::$app->user->id, 'model' => get_class($model), 'model_id' => $id]);
            if (!$userCollect) {
                $collect = new Collection([
                    'user_id' => Yii::$app->user->id,
                    'model_id' => $id,
                    'model' => get_class($model),
                    'subject' => $model->title,
                ]);
                if ($collect->save()) {
                    $model->updateCounters(['collections' => 1]);
                } elseif (!$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
                Yii::$app->getResponse()->setStatusCode(201);
            } else {
                Yii::$app->getResponse()->setStatusCode(200);
            }
            return;
        }
        throw new MethodNotAllowedHttpException();
    }

    /**
     * 回答问题
     * @param int $id
     * @return object|ActiveDataProvider|Question
     * @throws ServerErrorHttpException
     */
    public function actionAnswer($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isGet) {
            return Yii::createObject([
                'class' => ActiveDataProvider::className(),
                'query' => Answer::find()->where(['question_id' => $model->id]),
            ]);
        } else {
            $answer = new Answer(['question_id' => $model->id]);
            $answer->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($answer->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', array_values($answer->getPrimaryKey(true)));
                $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            return $model;
        }
    }

    /**
     * 获取 Model
     * @param int $id
     * @return Question
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if (($model = Question::findOne($id)) != null) {
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
        if ($action === 'update' || $action === 'delete') {
            if ($model->user_id !== Yii::$app->user->id) {
                throw new ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
            }
        }
    }
}