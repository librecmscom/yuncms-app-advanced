<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yuncms\article\models\ArticleSupport;
use api\modules\v1\ActiveController;
use api\modules\v1\models\Article;
use api\modules\v1\models\ArticleCollection;
use api\modules\v1\models\ArticleComment;

/**
 * Class ArticleController
 * @package api\modules\v1\controllers
 */
class ArticleController extends ActiveController
{
    /**
     * @var string the model class name. This property must be set.
     */
    public $modelClass = 'api\modules\v1\models\Article';

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'support' => ['POST'],
            'comment' => ['GET', 'POST'],
            'collection' => ['GET', 'POST', 'DELETE'],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     *
     * @param IndexAction $action
     * @param mixed $filter
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function prepareDataProvider(IndexAction $action, $filter)
    {
        $query = Article::find()->with('user')->active();
        if (!empty($filter)) {
            $query->andWhere($filter);
        }
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
     * 赞
     * @param integer $id
     * @return Article
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     */
    public function actionSupport($id)
    {
        $source = $this->findModel($id);
        if ($source->isSupported(Yii::$app->user->getId())) {
            Yii::$app->getResponse()->setStatusCode(200);
            return $source;
        } else {
            $model = new ArticleSupport();
            $model->load(Yii::$app->request->post(), '');
            $model->model_id = $source->id;
            if ($model->save() === false && !$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
            Yii::$app->getResponse()->setStatusCode(201);
            return $source;
        }
    }

    /**
     * 收藏
     * @param null $id
     * @return Article|ArticleCollection|array|null|object|void|ActiveDataProvider|\yii\db\ActiveRecordInterface
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
                'query' => $query = ArticleCollection::find()->where(['user_id' => Yii::$app->user->getId()])->with('user'),
            ]);
        } else if (!empty($id) && Yii::$app->request->isPost) {
            $source = $this->findModel($id);
            if (($model = $source->getCollections()->andWhere(['user_id' => Yii::$app->user->getId()])->one()) != null) {
                Yii::$app->getResponse()->setStatusCode(200);
                return $model;
            } else {
                $model = new ArticleCollection();
                $model->load(Yii::$app->request->post(), '');
                $model->subject = $source->title;
                $model->model_id = $source->id;
                if ($model->save() === false && !$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
                }
                Yii::$app->getResponse()->setStatusCode(201);
                return $model;
            }
        } else if (!empty($id) && Yii::$app->request->isDelete) {
            $source = $this->findModel($id);
            if (($model = $source->getCollections()->andWhere(['user_id' => Yii::$app->user->getId()])->one()) != null) {
                if ($model->delete()) {
                    Yii::$app->getResponse()->setStatusCode(204);
                    return;
                } elseif (!$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
            } else {
                throw new NotFoundHttpException("Object not found.");
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    /**
     * 评论
     * @param integer $id
     * @return object|ActiveDataProvider|ArticleComment
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionComment($id)
    {
        if (($source = $this->findModel($id)) != null) {
            if (Yii::$app->request->isPost) {//发布
                $model = new ArticleComment();
                $model->scenario = ArticleComment::SCENARIO_CREATE;
                $model->load(Yii::$app->request->post(), '');
                $model->model_id = $source->id;
                if ($model->save() === false && !$model->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
                }
                if ($model->to_user_id > 0) {
                    //notify(Yii::$app->user->id, $model->to_user_id, 'reply_comment', $source->title, $source->id, $model->content, 'article', $source->id);
                } else {
                    //notify(Yii::$app->user->id, $source->user_id, 'comment_article', $source->title, $source->id, $model->content, 'article', $source->id);
                }
                Yii::$app->getResponse()->setStatusCode(201);
                return $model;
            } else if (Yii::$app->request->isGet) {
                return Yii::createObject([
                    'class' => ActiveDataProvider::className(),
                    'query' => $query = ArticleComment::find()->with('user')->with('toUser')->where([
                        'model_id' => $source->id,
                    ])->with('user'),
                ]);
            }
            throw new MethodNotAllowedHttpException();
        }
        throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist'));
    }

    /**
     * 获取 Model
     * @param int $id
     * @return Article
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if (($model = Article::findOne($id)) != null) {
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
     * @param Article $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if (($action === 'update' || $action === 'delete') && !$model->isAuthor) {
            throw new ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
        }
    }
}