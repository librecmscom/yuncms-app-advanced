<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

/**
 * Class ArticleCollection
 * @package api\modules\v1\models
 */
class ArticleCollection extends \yuncms\article\models\ArticleCollection
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
        return $this->hasOne(Article::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}