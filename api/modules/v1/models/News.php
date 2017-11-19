<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use yii\web\Link;
use yii\helpers\Url;
use yii\web\Linkable;

/**
 * Class News
 * @package api\modules\v1\models
 */
class News extends \yuncms\news\models\News implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'user_id',
            'slug',
            'title',
            'description',
            'status',
            'views',
            'url',
            'published_at',
            'created_at',
            'updated_at'
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
            Link::REL_SELF => Url::to(['view', 'id' => $this->id], true),
            'edit' => Url::to(['view', 'id' => $this->id], true),
            'index' => Url::to(['index'], true),
        ];
    }
}