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
 * Class Tag
 * @package api\modules\v1\models
 */
class Tag extends \yuncms\tag\models\Tag implements Linkable
{
    /**
     * return HATEOAS
     * @see https://en.wikipedia.org/wiki/HATEOAS
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['/v1/tag/view', 'id' => $this->id], true),
            'index' => Url::to(['/v1/tag/index'], true),
        ];
    }
}