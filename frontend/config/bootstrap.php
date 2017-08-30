<?php
//设置分页居中
\Yii::$container->set('yii\widgets\ListView', [
    'layout' => "{items}\n<div class=\"text-center\">{pager}</div>",
]);
//默认分页15条
\Yii::$container->set('yii\data\Pagination', [
    'defaultPageSize' => 15,
]);