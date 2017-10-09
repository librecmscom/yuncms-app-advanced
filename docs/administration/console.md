# 控制台操作手册

#### 初始化开发环境

```bash
cd /path/to/app
./init --env=Development --overwrite=y
./yii migrate
```


```bash
cd /path/to/app
./init --env=Production --overwrite=y
./yii migrate
```

##### 压缩CSS JS资源

```bash
rpm -ivh jdk-8u25-linux-x64.rpm
//生成模板
./yii asset/template frontend/config/asset.php
//开始压缩
./yii asset frontend/config/asset.php frontend/config/assets_compressed.php
```

##### 生成语言包配置
```bash
./yii message/config backend/messages/config.php
./yii message/config frontend/messages/config.php
./yii message/config common/widgets/messages/config.php
```

#### 生成语言包

```bash
./yii message common/messages/config.php
./yii message backend/messages/config.php
./yii message frontend/messages/config.php
./yii message @yuncms/credit/messages/config.php
./yii message @yuncms/group/messages/config.php
```

##### 创建数据迁移文件(支持命名空间)

```
用Gii生成模型
php yii gii/model --ns=common\\models --modelClass=AdminLog --tableName=admin_log

./yii migrate/create yuncms\coin\migrations\create_coin_recharge_table
./yii migrate/create app\migrations\add_test_user
./yii migrate/create app\migrations\create_group_member_table
./yii migrate/create app\migrations\create_group_order_table
./yii migrate/create yuncms\credit\migrations\add_credit_field
```