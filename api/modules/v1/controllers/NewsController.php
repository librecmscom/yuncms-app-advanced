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
use api\modules\v1\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use api\modules\v1\models\News;
use yuncms\news\models\NewsSupport;

/**
 * Class ArticleController
 * @package api\modules\v1\controllers
 */
class NewsController extends ActiveController
{
    /**
     * @var string the model class name. This property must be set.
     */
    public $modelClass = 'api\modules\v1\models\News';

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'support' => ['POST'],
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
     */
    public function prepareDataProvider(IndexAction $action, $filter)
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $action->modelClass;
        $query = $modelClass::find()->with('user')->active();
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
     * @return News
     * @throws ServerErrorHttpException
     */
    public function actionSupport($id)
    {
        $source = $this->findModel($id);
        if ($source->isSupported(Yii::$app->user->getId())) {
            Yii::$app->getResponse()->setStatusCode(200);
            return $source;
        } else {
            $model = new NewsSupport();
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
     * 获取 Model
     * @param int $id
     * @return News
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if (($model = News::findOne($id)) != null) {
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
     * @param News $model the model to be accessed. If null, it means no specific model is being accessed.
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