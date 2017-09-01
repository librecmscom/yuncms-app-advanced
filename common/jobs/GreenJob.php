<?php

namespace common\jobs;

use Yii;
use yii\base\Object;
use yii\queue\Queue;
use yii\queue\RetryableJob;
use yii\httpclient\Client;
use yuncms\user\models\User;

/**
 * Class GreenJob.
 */
class GreenJob extends Object implements RetryableJob
{
    /**
     * @var int 要检查的ID
     */
    public $modelId;

    /**
     * @var string 要检查的模型
     */
    public $model;

    public $statusFiled;

    /**
     * @var string 要检查的字段1
     */
    public $field1;

    /**
     * @var string 要检查的字段2
     */
    public $field2;

    /**
     * @var string 要检查的字段3
     */
    public $field3;

    /**
     * @var string 要检查的字段4
     */
    public $field4;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
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
