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
    public $modelClass;

    /**
     * @var string 操作类型，取值范围为[“new”, “edit”, “share”, “others”]；也可以自定义的其他操作类型，但长度不超过64字节
     */
    public $action = 'new';

    /**
     * @var string 内容类别，取值范围为[“post”, “reply”, “comment”, “title”, “others”]；也可以自定义的其他类型，但长度不超过64字节
     */
    public $category = 'post';

    /**
     * @var string 要扫描的字段
     */
    public $scanField = 'content';

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($this->modelId)) != null) {
            $suggestion = $this->green([
                'action' => $this->action,
                'category' => $this->category,
                'content' => $model->{$this->scanField}
            ]);
            $modelClass::review($id, $suggestion);
        }
    }

    /**
     * 文本反垃圾
     * @param array $tasks
     * @return string 建议用户处理，取值范围：[“pass”, “review”, “block”], pass:文本正常，review：需要人工审核，block：文本违规，可以直接删除或者做限制处理
     */
    protected function green($tasks)
    {
        $results = Yii::$app->green->textScan([$tasks]);
        $result = array_pop($results);
        if ($result['code'] == 200) {
            $suggestion = 'pass';
            foreach ($result['results'] as $res) {
                if ($res['suggestion'] == 'block') {//直接删除
                    $suggestion = 'block';
                    break;
                } else if ($res['suggestion'] == 'review') {//人工审核
                    $suggestion = 'review';
                    break;
                }
            }
        } else {
            $suggestion = 'review';
        }
        return $suggestion;
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
