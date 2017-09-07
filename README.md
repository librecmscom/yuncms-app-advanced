# Yii 2 Advanced Project Template

[![Latest Stable Version](https://poser.pugx.org/yuncms/yuncms-app-advanced/v/stable.png)](https://packagist.org/packages/yuncms/yuncms-app-advanced)
[![Total Downloads](https://poser.pugx.org/yuncms/yuncms-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yuncms/yuncms-app-advanced.svg?branch=master)](https://travis-ci.org/yuncms/yuncms-app-advanced)

## Run from source

- Install satis: `composer create-project yuncms/yuncms-app-advanced:dev-master --keep-vcs`
- Build a repository: `php init`

Documentation is at [docs/README.md](docs/README.md).

## Run as Docker container

Pull the image:

``` sh
docker pull yuncms/yuncms-app-advanced
```

## 目录结构

```
api
    config/              包含API置
    controllers/         包含API控制器类
    models/              包含API特定的模型类
    modules/             包含API相关模块
    runtime/             包含运行时生成的文件
    web/                 包含相关脚本和Web资源
common
    config/              包含共享配置
    mail/                包含电子邮件的视图文件
    models/              包含后端和前端中使用的模型类
console
    config/              包含控制台配置
    controllers/         包含控制台控制器（命令）
    migrations/          包含数据库迁移
    models/              包含控制台特定的模型类
    runtime/             包含运行时生成的文件
backend
    assets/              包含应用程序资源（如JavaScript和CSS）
    config/              包含后端配置
    controllers/         包含Web控制器类
    models/              包含后端特定的模型类
    runtime/             包含运行时生成的文件
    views/               包含Web应用程序的视图文件
    web/                 包含相关脚本和Web资源
frontend
    assets/              包含应用程序资源（如JavaScript和CSS）
    config/              包含前端配置
    controllers/         包含Web控制器类
    models/              包含前端特定的模型类
    runtime/             包含运行时生成的文件
    views/               包含Web应用程序的视图文件
    web/                 包含相关脚本和Web资源
    widgets/             包含前端小部件
vendor/                  包含相关的第三方软件包
environments/            包含基于环境的覆盖
tests                    包含应用程序的各种测试
    codeception/         包含使用Codeception PHP测试框架开发的测试
```
