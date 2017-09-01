<?php

namespace common\jobs;

use Yii;
use yii\base\Object;
use yii\queue\Queue;
use yii\queue\RetryableJob;
use yii\httpclient\Client;
use yuncms\user\models\User;
use yuncms\authentication\models\Authentication;

/**
 * 实名认证任务处理类
 * @package common\jobs
 */
class AuthenticationJob extends Object implements RetryableJob
{
    /**
     * @var int 用户ID
     */
    public $userId;

    /**
     * 执行实名认证任务
     * @param Queue $queue
     */
    public function execute($queue)
    {
        if (($authentication = Authentication::findOne(['user_id' => $this->userId, 'id_type' => Authentication::TYPE_ID])) != null) {
            //获取身份证正面图像的保存路径
            //$passportCoverPath = Yii::getAlias(Yii::$app->settings->get('authentication', 'idCardPath')) . $authentication->passport_cover;
            $result = Yii::$app->id98->getIdCard($authentication->real_name, $authentication->id_card);
            if ($result['success'] = true) {
                if ($result['data'] == 1) {
                    $authentication->status = Authentication::STATUS_AUTHENTICATED;
                    $authentication->failed_reason = '信息比对一致';
                } else if ($result['data'] == 2) {
                    $authentication->status = Authentication::STATUS_REJECTED;
                    $authentication->failed_reason = '姓名和身份证号码不一致';
                } else if ($result['data'] == 3) {
                    $authentication->status = Authentication::STATUS_REJECTED;
                    $authentication->failed_reason = '身份证中心查无此身份证号码';
                }
                $authentication->save(false);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}
