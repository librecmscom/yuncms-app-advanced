<?php
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use xutl\wechat\JsWidget;

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="format-detection" content="telephone=no"/>
        <?= Html::csrfMetaTags() ?>
        <?= Html::tag('title', Html::encode($this->title)); ?>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?= JsWidget::widget(); ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>