<?php
//���÷�ҳ����
\Yii::$container->set('yii\widgets\ListView', [
    'layout' => "{items}\n<div class=\"text-center\">{pager}</div>",
]);
//Ĭ�Ϸ�ҳ15��
\Yii::$container->set('yii\data\Pagination', [
    'defaultPageSize' => 15,
]);