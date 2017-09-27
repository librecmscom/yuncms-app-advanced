<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yuncms\tag\models\Tag;

/**
 * 主题模型
 * @package api\modules\v1\models
 */
class Topic extends Tag
{
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['v1/topic/view', 'id' => $this->id], true),
            'edit' => Url::to(['v1/topic/view', 'id' => $this->id], true),
            'index' => Url::to(['v1/topics'], true),
        ];
    }
}