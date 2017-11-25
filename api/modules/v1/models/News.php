<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use Yii;
use yii\web\Link;
use yii\helpers\Url;
use yii\web\Linkable;

/**
 * Class News
 * @package api\modules\v1\models
 */
class News extends \yuncms\news\models\News implements Linkable
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'url',
            'status',
            'user',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * 扩展字段定义
     * @return array
     */
    public function extraFields()
    {
        return [
            'user'
        ];
    }

    /**
     * User Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * return HATEOAS
     * @see https://en.wikipedia.org/wiki/HATEOAS
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['/v1/news/view', 'id' => $this->id], true),
            'edit' => Url::to(['/v1/news/view', 'id' => $this->id], true),
            'index' => Url::to(['/v1/news/index'], true),
        ];
    }
}