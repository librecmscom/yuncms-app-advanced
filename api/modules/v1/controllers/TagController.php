<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use yii\data\ActiveDataProvider;
use api\modules\v1\ActiveController;
use api\modules\v1\models\Tag;


/**
 * 主题
 * @package api\modules\v1\controllers
 */
class TagController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Tag';

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
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [
            'search' => ['GET'],
        ];
    }

    /**
     * 主题搜索
     * @param string $tag
     * @return ActiveDataProvider
     */
    public function actionSearch($tag)
    {
        $query = Tag::find()->andWhere(['like', 'name', $tag]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'frequency' => SORT_DESC,
                    'id' => SORT_ASC,
                ]
            ],
        ]);
        return $dataProvider;
    }
}