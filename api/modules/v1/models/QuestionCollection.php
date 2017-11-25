<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

/**
 * Class QuestionCollection
 * @package api\modules\v1\models
 */
class QuestionCollection extends \yuncms\question\models\QuestionCollection
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'user',
            'source',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Question::className(), ['id' => 'model_id']);
    }


    /**
     * 关联用户
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}