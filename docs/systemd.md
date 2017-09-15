# 使用` systemd` 管理 `Yii` 队列服务,实现故障重启、开机自启动等功能

以 `Centos7` 为例

在 `/usr/lib/systemd/system` 目录新建 `yii-queue.service` 文件

```bash
[Unit]
Description=Yii Queue Server
After=network.target
After=syslog.target
[Service]
Type=forking
PIDFile=/var/run/yii-queue.pid
ExecStart=/path/to/yii queue/listen --verbose=1 --color=0 >> /var/logs/yii-queue.log 2>&1
ExecStop=/bin/kill $MAINPID
ExecReload=/bin/kill -USR1 $MAINPID
Restart=always
[Install]
WantedBy=multi-user.target graphical.target
```

接着设置

```bash
#重新加载配置文件
systemctl daemon-reload

#启用
systemctl enable yii-queue.service

#启动
systemctl start yii-queue.service

#停止
systemctl stop yii-queue.service
```
