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
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use api\modules\v1\Controller;
use api\modules\v1\models\Message;

/**
 * Class MessageController
 * @package api\modules\v1\controllers
 */
class MessageController extends Controller
{
    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'unread-messages' => ['GET', 'HEAD'],
        ];
    }

    /**
     * 收件箱
     * @return object|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $query = Message::find()->where(['parent' => null])
            ->andWhere(['or', ['from_id' => Yii::$app->user->getId()], ['user_id' => Yii::$app->user->getId()]])->with('user')->with('from');
        if (!empty($filter)) {
            $query->andWhere($filter);
        }
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * 发私信
     * @return Message|\yii\db\ActiveRecord
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate(){
        /* @var $model \yii\db\ActiveRecord */
        $model = new Message();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    /**
     * 获取会话
     * @param integer $id
     * @return object|ActiveDataProvider
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dialogue = Message::find()->where(['id' => $model->id])->orWhere(['parent' => $model->id]);
        $dialogue->orderBy(['created_at' => SORT_ASC]);
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $dialogue,
        ]);
    }

    /**
     * 未读通知数目
     * @return array
     * @throws \Exception
     */
    public function actionUnreadMessages()
    {
        $total = Message::getDb()->cache(function ($db) {
            return Message::find()->where(['user_id' => Yii::$app->user->id, 'status' => Message::STATUS_NEW])->count();
        }, 60);
        return ['total' => $total];
    }

    /**
     * 获取会话
     * @param int $id
     * @return Message
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Message::find()
                ->where(['id' => $id, 'parent' => null])
                ->andWhere(['or', ['from_id' => Yii::$app->user->id], ['user_id' => Yii::$app->user->id]])
                ->limit(1)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException("Object not found: $id");
        }
    }
}