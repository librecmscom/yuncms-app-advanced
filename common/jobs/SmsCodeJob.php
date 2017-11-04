<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace common\jobs;

use Yii;
use xutl\sms\CaptchaJob;

/**
 * Class SmsJob
 * @package common\jobs
 */
class SmsCodeJob extends CaptchaJob
{
    public $mobile;

    public $templateCode = '204799';

    public $code;

    public function getTemplateParam()
    {
        return [$this->code];
    }
}