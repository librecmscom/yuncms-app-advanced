<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = 'My Yii Application';
?>
<?php $this->beginBlock('jumbotron'); ?>
<div class="jumbotron text-center hidden-xs">
    <h4>欢迎加入 YUNCMS 站长社区，一起记录站长的世界
        <a class="btn btn-primary ml-10" href="<?=Url::to(['/user/registration/register'])?>"
           role="button">立即注册</a>
        <a class="btn btn-default ml-5"
           href="<?=Url::to(['/user/security/login'])?>"
           role="button">用户登录</a>
    </h4>
</div>
<?php $this->endBlock(); ?>

<div class="row mt-10">
    <div class="col-xs-12 col-md-9 main">
        <div class="widget-box mb-10">
            <h4 class="widget-box-title">最新推荐</h4>
            <div class="job-list-item row">
                <div class="col-md-6">
                    <div id="carousel-recommendation" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-recommendation" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-recommendation" data-slide-to="1"></li>
                            <li data-target="#carousel-recommendation" data-slide-to="2"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="leftmodbox">
                            <div class="item active">
                                <a href="" target="_blank"><img
                                            src="http://www.yiichina.com/uploads/avatar/000/03/14/28_avatar_middle.jpg"
                                            alt="测试测试测试"></a>
                                <div class="carousel-caption">
                                    <h4>测试测试测试</h4>
                                </div>
                            </div>
                            <div class="item active">
                                <a href="" target="_blank"><img
                                            src="http://www.yiichina.com/uploads/avatar/000/03/14/28_avatar_middle.jpg"
                                            alt="测试测试测试"></a>
                                <div class="carousel-caption">
                                    <h4>测试测试测试</h4>
                                </div>
                            </div><div class="item active">
                                <a href="" target="_blank"><img
                                            src="http://www.yiichina.com/uploads/avatar/000/03/14/28_avatar_middle.jpg"
                                            alt="测试测试测试"></a>
                                <div class="carousel-caption">
                                    <h4>测试测试测试</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="widget-links list-unstyled">
                        <li class="widget-links-item">
                            <a href="https://wenda.tipask.com/article/4924" target="_blank">如何有效的提高百度收录速度</a>
                        </li>
                        <li class="widget-links-item">
                            <a href="http://wenda.tipask.com/article/78" target="_blank">论正确提问的姿势</a>
                        </li>
                        <li class="widget-links-item">
                            <a href="http://wenda.tipask.com/article/32"
                               target="_blank">百度搜索升级,BaiduSpider3.0来看看都有哪些功能！</a>
                        </li>
                        <li class="widget-links-item">
                            <a href="http://wenda.tipask.com/article/28" target="_blank">奥巴马为何卸任后想做科技业的风险投资人？</a>
                        </li>
                        <li class="widget-links-item">
                            <a href="http://wenda.tipask.com/article/4" target="_blank">干货分享：网站优化的那些事</a>
                        </li>
                        <li class="widget-links-item">
                            <a href="http://wenda.tipask.com/article/15" target="_blank">知乎问答社区面临转型问题 知乎要变现了</a>
                        </li>
                        <li class="widget-links-item">
                            <a href="http://wenda.tipask.com/article/8" target="_blank">行家招募令，大牛快来认证吧！</a>
                        </li>
                        <li class="widget-links-item">
                            <a href="http://wenda.tipask.com/question/4" target="_blank">个人站长做网站没有内容来源怎么办？</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="widget-box">
            <div class="job-list-item row">
                <div class="col-md-6">
                    <h4 class="widget-box-title">最新问题 <a href="<?=Url::to(['/question/question/index'])?>"
                                                         target="_blank" title="更多">»</a></h4>
                    <ul class="widget-links list-unstyled">
                        <li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li>
                        <li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li><li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li><li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li><li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li><li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li><li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li><li class="widget-links-item">
                            <a title="测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题" target="_blank"
                               href="">测试问题问题测试问题问题测试问题问题测试问题问题测试问题问题</a>
                            <small class="text-muted">0 回答</small>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4 class="widget-box-title">悬赏问题 <a href="<?=Url::to(['/question/question/index', 'order' => 'reward'])?>"
                                                         target="_blank" title="更多">»</a></h4>

                    <ul class="widget-links list-unstyled">
                        <li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li>
                        <li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li><li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li><li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li><li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li><li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li><li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li><li class="widget-links-item">
                            <span class="text-gold"><i class="fa fa-database"></i> 5</span>
                            <a target="_blank" title="测试问题问题问题"
                               href="">测试问题问题问题</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="widget-box">
            <div class="job-list-item row">
                <div class="col-md-6">
                    <h4 class="widget-box-title">热门文章 <a href="<?=Url::to(['/question/question/index', 'order' => 'reward'])?>"
                                                         title="更多">»</a></h4>
                    <ul class="widget-links list-unstyled">
                        <li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li>
                        <li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4 class="widget-box-title">最新文章 <a href="<?=Url::to(['/question/question/index', 'order' => 'reward'])?>"
                                                         title="更多">»</a></h4>
                    <ul class="widget-links list-unstyled">
                        <li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li><li class="widget-links-item">
                            <a title="测试标题标题测试标题标题测试标题标题" target="_blank"
                               href="">测试标题标题测试标题标题测试标题标题测试标题标题</a>
                            <small class="text-muted">28484 浏览</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 hidden-xs side">
        <div class="side-alert alert alert-link">
            <a href="<?= Url::to(['/question/question/create']) ?>"
               class="btn btn-warning btn-block"><?= Yii::t('question', 'Ask a Question') ?></a>
            <a href="<?= Url::to(['/article/article/create']) ?>"
               class="btn btn-primary btn-block"><?= Yii::t('article', 'Write a article'); ?></a>
        </div>

        <?= \yuncms\question\widgets\Tags::widget() ?>

        <div class="widget-box mt30">
            <h2 class="widget-box-title">
                财富榜<a href="<?= Url::to(['/top/coins']) ?>" title="更多">»</a>
            </h2>
            <ol class="widget-top10">
                <?php
                $topAnswerUsers = \yuncms\user\models\Extend::top('coins', 8);
                ?>
                <?php foreach ($topAnswerUsers as $index => $topAnswerUser): ?>
                    <li class="text-muted">
                        <img class="avatar-32"
                             src="<?= $topAnswerUser->user->getAvatar('big') ?>">
                        <a href="<?= Url::to(['/user/space/view', 'id' => $topAnswerUser->user_id]) ?>"
                           class="ellipsis"><?= $topAnswerUser->user->username ?></a>
                        <span class="text-muted pull-right"><?= $topAnswerUser->coins ?> 金币</span>
                    </li>
                <?php endforeach; ?>

            </ol>
        </div>
    </div>
</div>