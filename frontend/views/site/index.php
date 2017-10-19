<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yuncms\article\models\Article;
use yuncms\question\models\Question;

//$this->title = 'My Yii Application';
?>
<?php $this->beginBlock('jumbotron'); ?>
<div class="jumbotron text-center hidden-xs">
    <h4>欢迎加入 YUNCMS 站长社区，一起记录站长的世界
        <a class="btn btn-primary ml-10" href="<?= Url::to(['/user/registration/register']) ?>"
           role="button">立即注册</a>
        <a class="btn btn-default ml-5"
           href="<?= Url::to(['/user/security/login']) ?>"
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
                            <li data-target="#carousel-recommendation" data-slide-to="3"></li>
                            <li data-target="#carousel-recommendation" data-slide-to="4"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <?php
                        $articles = Article::getDb()->cache(function ($db) {
                            return Article::find()->containCover()->newest()->limit(5)->all();
                        }, 3600);
                        ?>
                        <div class="carousel-inner" role="leftmodbox">
                            <?php foreach ($articles as $article): ?>
                                <div class="item active">
                                    <a href="<?= Url::to(['/article/article/view', 'id' => $article->id]) ?>"
                                       target="_blank"><img
                                                src="<?= $article->cover ?>"
                                                alt="<?= Html::encode($article->title) ?>"></a>
                                    <div class="carousel-caption">
                                        <h4><?= Html::encode($article->title) ?></h4>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    $articles = Article::getDb()->cache(function ($db) {
                        return Article::find()->newSupport()->limit(8)->all();
                    }, 3600);
                    ?>
                    <ul class="widget-links list-unstyled">
                        <?php foreach ($articles as $article): ?>
                            <li class="widget-links-item">
                                <a title="<?= Html::encode($article->title) ?>" target="_blank"
                                   href="<?= Url::to(['/article/article/view', 'id' => $article->id]) ?>"><?= Html::encode($article->title) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="widget-box">
            <div class="job-list-item row">
                <div class="col-md-6">
                    <h4 class="widget-box-title">最新问题 <a href="<?= Url::to(['/question/question/index']) ?>"
                                                         target="_blank" title="更多">»</a></h4>
                    <?php
                    $questions = Question::getDb()->cache(function ($db) {
                        return Question::find()->newest()->limit(8)->all();
                    }, 3600);
                    ?>
                    <ul class="widget-links list-unstyled">
                        <?php foreach ($questions as $question): ?>
                            <li class="widget-links-item">
                                <a title="<?= Html::encode($question->title) ?>" target="_blank"
                                   href="<?= Url::to(['/question/question/view', 'id' => $question->id, 'alias' => $question->alias]) ?>"><?= Html::encode($question->title) ?></a>
                                <small class="text-muted"><?= Html::encode($question->answers) ?> 回答</small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4 class="widget-box-title">悬赏问题 <a
                                href="<?= Url::to(['/question/question/index', 'order' => 'reward']) ?>"
                                target="_blank" title="更多">»</a></h4>
                    <?php
                    $questions = Question::getDb()->cache(function ($db) {
                        return Question::find()->reward()->limit(8)->all();
                    }, 3600);
                    ?>
                    <ul class="widget-links list-unstyled">
                        <?php foreach ($questions as $question): ?>
                            <li class="widget-links-item">
                                <span class="text-gold"><i class="fa fa-database"></i> <?= $question->price ?></span>
                                <a title="<?= Html::encode($question->title) ?>" target="_blank"
                                   href="<?= Url::to(['/question/question/view', 'id' => $question->id, 'alias' => $question->alias]) ?>"><?= Html::encode($question->title) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="widget-box">
            <div class="job-list-item row">
                <div class="col-md-6">
                    <h4 class="widget-box-title">热门文章 <a
                                href="<?= Url::to(['/article/article/index', 'order' => 'reward']) ?>"
                                title="更多">»</a></h4>
                    <?php
                    //首页显示排行榜
                    $articles = Article::getDb()->cache(function ($db) {
                        return Article::find()->hot()->limit(8)->all();
                    }, 3600);
                    ?>
                    <ul class="widget-links list-unstyled">
                        <?php foreach ($articles as $article): ?>
                            <li class="widget-links-item">
                                <a title="<?= Html::encode($article->title) ?>" target="_blank"
                                   href="<?= Url::to(['/article/article/view' , 'id' => $article->id]) ?>"><?= Html::encode($article->title) ?></a>
                                <small class="text-muted"><?= $article->views ?> 浏览</small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4 class="widget-box-title">最新文章 <a
                                href="<?= Url::to(['/question/question/index', 'order' => 'reward']) ?>"
                                title="更多">»</a></h4>
                    <?php
                    $articles = Article::getDb()->cache(function ($db) {
                        return Article::find()->newest()->limit(8)->all();
                    }, 3600);
                    ?>
                    <ul class="widget-links list-unstyled">
                        <?php foreach ($articles as $article): ?>
                            <li class="widget-links-item">
                                <a title="<?= Html::encode($article->title) ?>" target="_blank"
                                   href="<?= Url::to(['/article/article/view', 'id' => $article->id]) ?>"><?= Html::encode($article->title) ?></a>
                                <small class="text-muted"><?= $article->views ?> 浏览</small>
                            </li>
                        <?php endforeach; ?>
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
                           class="ellipsis"><?= $topAnswerUser->user->nickname ?></a>
                        <span class="text-muted pull-right"><?= $topAnswerUser->coins ?> 金币</span>
                    </li>
                <?php endforeach; ?>

            </ol>
        </div>
    </div>
</div>