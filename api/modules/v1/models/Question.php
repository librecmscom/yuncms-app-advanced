<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use Yii;
use yii\web\Link;
use yii\helpers\Url;
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
            'title',
            'alias',
            'price',
            'hide',
            'answers',
            'views',
            'followers',
            'collections',
            'comments',
            'tags',
            'isFollowed' => function () {
                return $this->isFollowed(Yii::$app->user->getId());
            },
            'isCollected' => function () {
                return $this->isCollected(Yii::$app->user->getId());
            },
            'status',
            'user',
            'content',
            'created_at',
            'updated_at',
            "created_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->created_at);
            },
            "updated_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->updated_at);
            },
        ];
    }

    /**
     * Collection Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getAttentions()
    {
        return $this->hasMany(QuestionAttention::className(), ['model_id' => 'id']);
    }

    /**
     * Collection Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getCollections()
    {
        return $this->hasMany(QuestionCollection::className(), ['model_id' => 'id']);
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
     * Tag Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%question_tag}}', ['question_id' => 'id']);
    }

    /**
     * return HATEOAS
     * @see https://en.wikipedia.org/wiki/HATEOAS
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['/v1/question/view', 'id' => $this->id], true),
            'edit' => Url::to(['/v1/question/view', 'id' => $this->id], true),
            'index' => Url::to(['/v1/question/index'], true),
        ];
    }
}