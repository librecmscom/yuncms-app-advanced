<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yuncms\core\validators\MobileValidator;

/**
 * 社交账户绑定手机号
 * @package api\modules\v1\models
 */
class UserSocialBindMobileForm extends Model
{
    /**
     * @var string
     */
    public $mobile;

    /**
     * @var string Password
     */
    public $password;

    /**
     * @var string 验证码
     */
    public $verifyCode;

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
            'mobile' => Yii::t('user', 'Mobile'),
            'verifyCode' => Yii::t('user', 'verifyCode')
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
     * 绑定手机
     * @return boolean
     */
    public function bingMobile()
    {
        if ($this->validate() && ($user = $this->getUser()) != null) {
            $user->resetPassword($this->password);
            $user->updateAttributes(['mobile' => $this->mobile]);
            return true;
        }
        return false;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return User::findOne(Yii::$app->user->getId());
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'recovery-form';
    }
}