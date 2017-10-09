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
 * Class Language
 * @package api\modules\v1\models
 */
class Language extends \yuncms\system\models\Language implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'iso_639_1',
            'iso_639_2',
            'iso_639_3'
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