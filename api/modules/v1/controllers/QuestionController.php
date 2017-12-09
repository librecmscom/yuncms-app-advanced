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
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use api\modules\v1\ActiveController;
use api\modules\v1\models\Question;
use api\modules\v1\models\QuestionAnswer;
use api\modules\v1\models\QuestionCollection;

/**
 * Class QuestionController
 * @package api\modules\v1\controllers
 */
class QuestionController extends ActiveController
{
    /**
     * @var string the model class name. This property must be set.
     */
    public $modelClass = 'api\modules\v1\models\Question';

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'collection' => ['GET', 'POST', 'DELETE'],
            'answer' => ['GET', 'POST'],
        ];
    }

    /**
     * 我回答的问题
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionMyAnswer()
    {
        $query = Question::find()->innerJoinWith([
            'answers' => function ($query) {
                /** @var \yii\db\ActiveQuery $query */
                $query->where([
                    QuestionAnswer::tableName() . '.user_id' => Yii::$app->user->getId()]);
            }
        ]);

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'id' => SORT_ASC,
                ]
            ],
        ]);
    }

    /**
     * 问题收藏
     * @param null $id
     * @return object|ActiveDataProvider
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCollection($id = null)
    {
        if (Yii::$app->request->isGet) {
            return Yii::createObject([
                'class' => ActiveDataProvider::className(),
                'query' => $query = QuestionCollection::find()->where(['user_id' => Yii::$app->user->getId()])->with('user'),
            ]);
        } else if (!empty($id) && Yii::$app->request->isDelete) {
            $question = $this->findModel($id);
            if (($collect = $question->getCollections()->where(['user_id' => Yii::$app->user->getId()])->one()) != null) {
                $collect->delete();
                Yii::$app->getResponse()->setStatusCode(204);
            } else {
                throw new NotFoundHttpException("Object not found.");
            }
        } else if (!empty($id) && Yii::$app->request->isPost) {
            $question = $this->findModel($id);
            if (($collect = $question->getCollections()->andWhere(['user_id' => Yii::$app->user->getId()])->one()) != null) {
                Yii::$app->getResponse()->setStatusCode(200);
            } else {
                $model = new QuestionCollection();
                $model->load(Yii::$app->request->post(), '');
                $model->subject = $question->title;
                $model->model_id = $question->id;
                if ($model->save() === false && !$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
                Yii::$app->getResponse()->setStatusCode(201);
                return $model;
            }
        } else {
            throw new MethodNotAllowedHttpException();
        }
    }

    /**
     * 回答问题
     * @param int $id
     * @return object|ActiveDataProvider|Question
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAnswer($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isGet) {
            return Yii::createObject([
                'class' => ActiveDataProvider::className(),
                'query' => QuestionAnswer::find()->where(['question_id' => $model->id]),
            ]);
        } else {
            $answer = new QuestionAnswer(['question_id' => $model->id]);
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