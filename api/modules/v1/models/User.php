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
 * Class User
 * @package api\modules\v1\models
 */
class User extends \yuncms\user\models\User implements Linkable
{
    public function fields()
    {
        return [
            'id',
            'username',
            'nickname',
            'faceUrl' => function () {
                return $this->getAvatar(self::AVATAR_MIDDLE);
            },
            'created_at',
            'blocked_at',
            'created_at',
            'blocked_at',
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
            Link::REL_SELF => Url::to(['/v1/user/view', 'id' => $this->id], true),
            'edit' => Url::to(['/v1/user/view', 'id' => $this->id], true),
            'index' => Url::to(['/v1/user/index'], true),
        ];
    }

    /**
     * 扩展字段定义
     * @return array
     */
    public function extraFields()
    {
        return ['profile', 'extra'];
    }
}