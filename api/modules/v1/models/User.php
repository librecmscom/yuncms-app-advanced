<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;

/**
 * Class User
 * @package api\modules\v1\models
 */
class User extends \yuncms\user\models\User
{
    public function fields()
    {
        return [
            // field name is the same as the attribute name
            'id',
            'username',
            'nickname',
            'email',
            'mobile' => 'mobile',
            'faceUrl' => function () {
                $this->getAvatar(self::AVATAR_MIDDLE);
            },
            'avatar' => function () {
                return $this->isAvatar;
            },
            'registration_ip',
            'created_at',
            'blocked_at',
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
            'edit' => Url::to(['user/view', 'id' => $this->id], true),
            'profile' => Url::to(['user/profile/view', 'id' => $this->id], true),
            'index' => Url::to(['users'], true),
        ];
    }

    public function extraFields()
    {
        return ['profile', 'extend'];
    }
}