<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yuncms\user\UserTrait;
use yuncms\user\models\User;

/**
 * SettingsForm gets user's username, email and password and changes them.
 *
 * @property User $user
 */
class UserSettingsForm extends Model
{
    use UserTrait;

    /**
     * @var string
     */
    public $new_password;

    /**
     * @var User
     */
    private $_user;

    /**
     * @return User
     */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = Yii::$app->user->identity;
        }
        return $this->_user;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'newPasswordLength' => ['new_password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'new_password' => Yii::t('user', 'New password')
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'settings-form';
    }

    /**
     * Saves new account settings.
     *
     * @return boolean
     */
    public function save()
    {
        if ($this->validate()) {
            $this->user->scenario = User::SCENARIO_PASSWORD;

            $this->user->password = $this->new_password;

            return $this->user->save();
        }
        return false;
    }
}
