<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use api\modules\v1\ActiveController;
use api\modules\v1\models\Topic;
use yii\data\ActiveDataProvider;

/**
 * 主题
 * @package api\modules\v1\controllers
 */
class TopicController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Topic';

    /**
     * 定义操作
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create'], $actions['update']);
        return $actions;
    }

    /**
     * 主题搜索
     * @param string $topic
     * @return ActiveDataProvider
     */
    public function actionSearch($topic)
    {
        $query = Topic::find()->where(['like', 'name', $topic]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
}