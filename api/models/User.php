<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\models;

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
            'faceUrl' => function () {
                return $this->getAvatar(self::AVATAR_MIDDLE);
            },
            'created_at',
            'blocked_at',
            'created_at',
            "created_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->created_at);
            },
            "updated_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->updated_at);
            },
            'blocked_datetime' => function () {
                return gmdate(DATE_ISO8601, $this->blocked_at);
            }
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtra()
    {
        return $this->hasOne(UserExtra::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * return HATEOAS
     * @see https://en.wikipedia.org/wiki/HATEOAS
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['/user/view', 'id' => $this->id], true),
            'edit' => Url::to(['/user/view', 'id' => $this->id], true),
            'index' => Url::to(['/user/index'], true),
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