<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\models;

/**
 * Class UserProfile
 * @package api\models
 */
class UserProfile extends \yuncms\user\models\UserProfile
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getExtra()
    {
        return $this->hasOne(UserExtra::className(), ['user_id' => 'user_id']);
    }
}