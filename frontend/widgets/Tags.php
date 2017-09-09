<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace frontend\widgets;

use yii\base\Widget;
use yuncms\tag\models\Tag;

/**
 * Class Tags
 * @package frontend\widgets
 */
class Tags extends Widget
{
    public $limit = 20;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $models = Tag::find()
            ->orderBy(['frequency' => SORT_DESC])
            ->limit($this->limit)
            ->all();

        return $this->render('tags', [
            'models' => $models,
        ]);
    }
}