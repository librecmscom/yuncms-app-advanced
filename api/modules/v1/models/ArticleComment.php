<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

/**
 * Class ArticleComment
 * @package api\modules\v1\models
 */
class ArticleComment extends \yuncms\article\models\ArticleComment
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'user',
            'toUser',
            'source',
            'parent',
            'content',
            'status',
            'created_at',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Article::className(), ['id' => 'model_id']);
    }

    /**
     * 关联用户
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * at 某人
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }
}