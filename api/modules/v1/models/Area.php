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
 * Class Area
 * @package api\modules\v1\models
 */
class Area extends \yuncms\system\models\Area implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'parent_id' => function () {
                return $this->parent;
            },
            'area_code',
            'post_code',
            'sort',
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
            'index' => Url::to(['index'], true),
        ];
    }
}