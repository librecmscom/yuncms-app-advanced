<?php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yuncms_dev',
            'username' => 'yuncms',
            'password' => '123456',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'queue'=>[
            'class' => 'yii\queue\file\Queue',
            'path' => '@console/runtime/queue',
        ],
    ],
];
