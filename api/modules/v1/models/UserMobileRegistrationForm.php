<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yuncms\user\models\User;
use yuncms\core\validators\MobileValidator;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 */
class UserMobileRegistrationForm extends Model
{
    /**
     * @var string User mobile
     */
    public $mobile;

    /**
     * @var string name
     */
    public $nickname;

    /**
     * @var string Password
     */
    public $password;

    /**
     * @var string 验证码
     */
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // nickname rules
            'nicknameLength' => ['nickname', 'string', 'min' => 3, 'max' => 255],
            'nicknameTrim' => ['nickname', 'filter', 'filter' => 'trim'],
            'nicknamePattern' => ['nickname', 'match', 'pattern' => User::$nicknameRegexp],
            'nicknameRequired' => ['nickname', 'required'],
            'nicknameUnique' => ['nickname', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This nickname has already been taken')],

            // mobile rules
            'mobileTrim' => ['mobile', 'filter', 'filter' => 'trim'],
            'mobileRequired' => ['mobile', 'required'],
            'mobilePattern' => ['mobile', MobileValidator::className()],
            'mobileUnique' => ['mobile', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This phone number has already been taken')],

            // password rules
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile' => Yii::t('user', 'mobile'),
            'nickname' => Yii::t('user', 'Nickname'),
            'password' => Yii::t('user', 'Password'),
            'verifyCode' => Yii::t('user', 'Verification Code'),
        ];
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     *
     * @return User|false
     */
    public function register()
    {
        if ($this->validate()) {
            /** @var User $user */
            $user = new User();
            $user->setScenario(User::SCENARIO_MOBILE_REGISTER);
            $this->loadAttributes($user);
            if ($user->create()) {
                return $user;
            }
        }
        return false;
    }

    /**
     * Loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide.
     *
     * By default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model.
     *
     * @param User $user
     */
    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes);
    }
}