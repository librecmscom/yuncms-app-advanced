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
    if ($event->sender->status !== yuncms\authentication\models\Authentication::STATUS_AUTHENTICATED) {
        Yii::$app->queue->push(new \common\jobs\AuthenticationJob([
            'userId' => $event->sender->user_id,
        ]));
    }
});
yii\base\Event::on(yuncms\authentication\models\Authentication::className(), yuncms\authentication\models\Authentication::EVENT_AFTER_UPDATE, function ($event) {
    if ($event->sender->status !== yuncms\authentication\models\Authentication::STATUS_AUTHENTICATED) {
        Yii::$app->queue->push(new \common\jobs\AuthenticationJob([
            'userId' => $event->sender->user_id,
        ]));
    }
});