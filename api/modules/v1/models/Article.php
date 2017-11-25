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
 * Class Article
 * @package api\modules\v1\models
 */
class Article extends \yuncms\article\models\Article implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'uuid',
            'category',
            'title',
            'sub_title',
            'description',
            'cover',
            'comments',
            'supports',
            'collections',
            'views',
            'isTop' => 'is_top',
            'isBest' => 'is_best',
            'isCollected' => function () {
                return $this->isCollected(Yii::$app->user->getId());
            },
            'isSupported' => function () {
                return $this->isSupported(Yii::$app->user->getId());
            },
            'status',
            'content',
            'user',
            'created_at',
            'updated_at',
            'published_at',
            "created_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->created_at);
            },
            "updated_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->updated_at);
            },
            'published_datetime' => function () {
                return gmdate(DATE_ISO8601, $this->published_at);
            }
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