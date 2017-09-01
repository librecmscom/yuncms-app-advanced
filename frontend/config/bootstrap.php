<?php
//设置分页居中
Yii::$container->set('yii\widgets\ListView', [
    'layout' => "{items}\n<div class=\"text-center\">{pager}</div>",
]);

//默认分页15条
Yii::$container->set('yii\data\Pagination', [
    'defaultPageSize' => 15,
]);

// 自动化实名认证事件
yii\base\Event::on(yuncms\authentication\models\Authentication::className(), yuncms\authentication\models\Authentication::EVENT_AFTER_INSERT, function ($event) {
    Yii::$app->queue->delay(10)->push(new \common\jobs\AuthenticationJob([
        'userId' => $event->sender->user_id,
    ]));
});