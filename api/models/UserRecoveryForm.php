<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\models;

use Yii;
use yii\base\Model;
use yuncms\core\validators\MobileValidator;
use yuncms\user\models\User;

/**
 * Model for collecting data on password recovery.
 *
 * @property \yuncms\user\Module $module
 */
class UserRecoveryForm extends Model
{
    /**
     * @var string
     */
    public $mobile;

    /**
     * @var string 验证码
     */
    public $verifyCode;

    /**
     * @var string
     */
    public $password;

    /**
     * @var User
     */
    protected $user;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password')
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'mobileTrim' => ['mobile', 'filter', 'filter' => 'trim'],
            'mobileRequired' => ['mobile', 'required'],
            'mobilePattern' => ['mobile', MobileValidator::className()],
            'mobileExist' => ['mobile', 'exist', 'targetClass' => User::className(), 'message' => Yii::t('user', 'There is no user with this mobile')],

            'passwordRequired' => ['password', 'required'],
            'passwordLength' => ['password', 'string', 'min' => 6],

            // verifyCode needs to be entered correctly
            'verifyCodeRequired' => ['verifyCode', 'required'],
            'verifyCodeString' => ['verifyCode', 'string', 'min' => 5, 'max' => 7],
            'verifyCodeValidator' => ['verifyCode',
                'xutl\sms\captcha\CaptchaValidator',
                'captchaAction' => '/v1/sms/verify-code',
                'skipOnEmpty' => false,
                'message' => Yii::t('app', 'Phone verification code input error.')
            ],
        ];
    }

    /**
     * 重置密码
     * @return boolean
     */
    public function resetPassword()
    {
        if ($this->validate() && ($user = $this->getUser()) != null) {
            $user->resetPassword($this->password);
            return true;
        }
        return false;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return User::findByMobile($this->mobile);
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'recovery-form';
    }
}
