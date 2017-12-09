<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = $name;

?>

<div class="page msg_warn js_show">
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title"><?= Html::encode($this->title) ?></h2>
            <p class="weui-msg__desc"><?= nl2br(Html::encode($message)) ?></p>
        </div>

        <div class="weui-msg__opr-area">
            <p>
                The above error occurred while the Web server was processing your request.
            </p>
            <p>Please contact us if you think this is a server error. Thank you.
            </p>
        </div>
        <div class="weui-msg__extra-area">
            <div class="weui-footer">
                <p class="weui-footer__text">Copyright © 2008-<?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?>.</p>
            </div>
        </div>
    </div>
</div>
