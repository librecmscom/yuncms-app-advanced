<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yuncms\article\models\Article;
use yii\base\InvalidConfigException;

/**
 * 获取热门文章
 *
 * ````
 * <?= \frontend\widgets\PopularArticle::widget(['limit'=>10,'cache'=>3600]); ?>
 * ````
 */
class PopularArticle extends Widget
{
    /**
     * @var int 需要显示的数量
     */
    public $limit = 8;

    /**
     * @var int 缓存时间
     */
    public $cache = 1;

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        if (empty ($this->limit)) {
            throw new InvalidConfigException ('The "limit" property must be set.');
        }
    }

    /** @inheritdoc */
    public function run()
    {
        //首页显示排行榜
        $models = Article::getDb()->cache(function ($db) {
            return Article::find()->hot()->limit($this->limit)->all();
        }, $this->cache);
        return $this->render('popular_article', [
            'models' => $models,
        ]);
    }
}
?>
