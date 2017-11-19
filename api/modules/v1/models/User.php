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
            // field name is the same as the attribute name
            'id',
            'username',
            'nickname',
            'email',
            'faceUrl' => function () {
                $this->getAvatar(self::AVATAR_MIDDLE);
            },
            'avatar',
            'mobile' => 'mobile',
            'registration_ip',
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
            Link::REL_SELF => Url::to(['view', 'id' => $this->id], true),
            'edit' => Url::to(['view', 'id' => $this->id], true),
            'index' => Url::to(['index'], true),
        ];
    }

    /**
     * À©Õ¹×Ö¶Î¶¨Òå
     * @return array
     */
    public function extraFields()
    {
        return ['profile', 'extra'];
    }
}