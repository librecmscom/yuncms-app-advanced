<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use Yii;

/**
 * Class QuestionAnswer
 * @package api\modules\v1\models
 */
class QuestionAnswer extends \yuncms\question\models\QuestionAnswer
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            "id",
            "question",
            'user',
            "content",
            "adopted_at",
            "supports",
            "comments",
            'isSupported' => function () {
                return $this->isSupported(Yii::$app->user->getId());
            },
            "created_at",
            "updated_at",
            "created_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->created_at);
            },
            "updated_datetime" => function () {
                return gmdate(DATE_ISO8601, $this->updated_at);
            },
        ];
    }
}