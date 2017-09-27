<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$asset = AppAsset::register($this);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
$this->title = $this->title ? $this->title . ' - ' . Yii::$app->settings->get('title', 'system') : Yii::$app->settings->get('title', 'system');
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->settings->get('keywords', 'system')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->settings->get('description', 'system')]);
$this->registerJs('App.init();')
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?= Html::tag('title', Html::encode($this->title)); ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Header
================================================== -->
<header class="top-common-nav">
    <!-- Nav -->
    <?= $this->render(
        '//layouts/_nav.php', ['asset' => $asset]
    ) ?>
</header>
<div class="top-alert mt-60 clearfix text-center">
    <!--[if lt IE 9]>
    <div class="alert alert-danger topframe" role="alert">你的浏览器实在<strong>太太太太太太旧了</strong>，放学别走，升级完浏览器再说
        <a target="_blank" class="alert-link" href="http://browsehappy.com">立即升级</a>
    </div>
    <![endif]-->
    <?= Alert::widget() ?>
</div>

<!-- Main
================================================== -->
<div class="wrap">
    <?php if (isset($this->blocks['jumbotron'])): ?>
        <?= $this->blocks['jumbotron'] ?>
    <?php endif; ?>

    <?php if (!empty($content)): ?>
        <div class="container">
            <?php if (isset($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->params['breadcrumbs'],
                ]) ?>
            <?php endif; ?>
            <?= $content ?>
        </div><!-- /.container -->
    <?php endif; ?>
</div>

<!-- Modal
================================================== -->
<?= Modal::widget([
    'options' => ['id' => 'modal'],
]); ?>

<!-- Footer
================================================== -->
<?= $this->render(
    '//layouts/_footer.php', ['asset' => $asset]
) ?>
<?=Yii::$app->settings->get('analysisCode', 'system')?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
