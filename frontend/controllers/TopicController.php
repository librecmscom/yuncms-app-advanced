<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace frontend\controllers;


use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\caching\DbDependency;
use yii\caching\TagDependency;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yuncms\tag\models\Tag;

/**
 * Tag controller
 */
class TopicController extends Controller
{

    public function behaviors()
    {
        return [
            'pageCache' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 24 * 3600 * 365, // 1 year
                'variations' => [
                    Yii::$app->user->id,
                    Yii::$app->language,
                    Yii::$app->request->get('page'),
                ],
                'dependency' => [
                    'class' => 'yii\caching\ChainedDependency',
                    'dependencies' => [
                        new TagDependency(['tags' => ['tags']]),
                        new DbDependency(['sql' => 'SELECT MAX(id) FROM ' . Tag::tableName()])
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'follow' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@', '?']
                    ]
                ],
            ],
        ];
    }

    /**
     * 标签列表页
     *
     * @return string
     */
    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
        $dataProvider = new ActiveDataProvider([
            'query' => Tag::find()->orderBy(['frequency' => SORT_DESC]),
            'pagination' => [
                'defaultPageSize' => 16,
                'pageSize' => 16
            ]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function findModel($name)
    {
        if (($model = Tag::findOne(['name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}