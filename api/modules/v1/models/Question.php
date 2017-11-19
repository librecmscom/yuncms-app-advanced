<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * Class Question
 * @package api\modules\v1\models
 */
class Question extends \yuncms\question\models\Question implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'user_id',
            'nickname' => function () {
                return $this->user->nickname;
            },
            'title',
            'alias',
            'price',
            'hide',
            'content',
            'answers',
            'views',
            'followers',
            'collections',
            'comments',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * User Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Answer Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * return HATEOAS
     * @see https://en.wikipedia.org/wiki/HATEOAS
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['view', 'id' => $this->id], true),
            'edit' => Url::to(['view', 'id' => $this->id], true),
            'index' => Url::to(['index'], true),
        ];
    }
}