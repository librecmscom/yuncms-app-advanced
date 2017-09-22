<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace console\controllers;

use yii\console\Controller;

/**
 * Class WebSocketController
 * @package console\controllers
 */
class WebSocketController extends Controller
{
    public $port = 9501;

    private $_server;

    public function init()
    {
        $this->server = new \swoole_websocket_server("0.0.0.0", 9501);
        $this->server->on('workerStart', function ($server, $workerId) {
            $client = new \swoole_redis;
            $client->on('message', function (\swoole_redis $client, $result) use ($server) {
                if ($result[0] == 'message') {
                    foreach ($server->connections as $fd) {
                        $server->push($fd, $result[1]);
                    }
                }
            });
            $client->connect('127.0.0.1', 6379, function (\swoole_redis $client, $result) {
                $client->subscribe('msg_0');
            });
        });

        $this->server->on('open', function ($server, $request) {

        });

        $this->server->on('message', function (\swoole_websocket_server $server, $frame) {
            $server->push($frame->fd, "hello");
        });

        $this->server->on('close', function ($serv, $fd) {

        });
    }

    public function actionRun()
    {
        $this->server->start();
    }
}