# 使用` systemd` 管理 `Yii` 服务,实现故障重启、开机自启动、执行关机脚本等功能

## 队列管理

以 `Centos7` 为例, 在 `/usr/lib/systemd/system` 目录新建 `yii-queue.service` 文件

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

## 如何使用systemd在系统关闭时运行脚本

假设您已经创建好了脚本，并且测试其运行无误。那么，如下步骤可以让您使用 `systemd` 在系统关闭时运行脚本。
首先，在 `/etc/systemd/system` 下创建一个文件 `run-script-when-shutdown.service`，并且让其内容如下

```bash
[Unit]
Description=service to run script when shutdown
After=syslog.target network.target

[Service]
Type=simple
ExecStart=/bin/true
ExecStop=path_to_script_to_run
RemainAfterExit=yes
[Install]
WantedBy=default.target
```

而后，执行如下命令，使能新创建的服务

```bash
systemctl enable run-script-when-shutdown
systemd start run-script-when-shutdown
```

为了便于调整，您可以配置 `run-script-when-shutdown` 运行固定的脚本。需要的时候，相关人员可以修改这个您固定的脚本。正如 `/etc/rc.local` 的工作方式。
当您不再需要运行这个服务时，您可以这样操作

```bash
systemctl disable run-script-when-shutdown
```

如此操作后您甚至可以删掉这个文件。

