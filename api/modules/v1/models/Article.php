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
            'user_id',
            'nickname' => function () {
                return $this->user->nickname;
            },
            'category_id',
            'title',
            'sub_title',
            'cover',
            'description',
            'comments',
            'supports',
            'collections',
            'views',
            'is_top',
            'is_best',
            'content',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * return HATEOAS
     * @see https://en.wikipedia.org/wiki/HATEOAS
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['v1/article/view', 'id' => $this->id], true),
            'edit' => Url::to(['v1/article/view', 'id' => $this->id], true),
            'index' => Url::to(['v1/articles'], true),
        ];
    }
}