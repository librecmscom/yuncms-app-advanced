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
            $passportCoverPath = Yii::getAlias(Yii::$app->settings->get('authentication', 'idCardPath')) . $authentication->passport_cover;

            //姓名
            $authentication->real_name;
            //证件号
            $authentication->id_card;


            $http = new Client();
            //TODO 具体实现
            //$response = $http->createRequest()->send();
            //if ($response->isOk) {
            $status = true;
            if ($status) {
                $authentication->status = Authentication::STATUS_AUTHENTICATED;
            } else {
                $authentication->status = Authentication::STATUS_REJECTED;
                $authentication->failed_reason = '证件审核失败，请重新提交审核！';
            }
            $authentication->save(false);
            //}

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
