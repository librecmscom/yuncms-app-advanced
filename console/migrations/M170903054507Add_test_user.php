<?php

namespace app\migrations;

use yii\db\Migration;

class M170903054507Add_test_user extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //添加默认超级管理员帐户 密码是 123456
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'nickname' => 'Administrator',
            'email' => 'admin@example.com',
            'mobile' => '13800138000',
            'auth_key' => '0B8C1dRH1XxKhO15h_9JzaN0OAY9WprZ',
            'password_hash' => '$2y$13$BzPeMPVIFLkiZXwkjJ/HZu0o6Mk0EUQdePC0ufnpzJCzIb4sOrUKK',
            'email_confirmed_at' => time(),
            'mobile_confirmed_at' => time(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id' => 1,
            'gender' => 0,
            'mobile' => '13800138000',
            'email' => 'admin@example.com',
            'country' => 'CN',
            'province' => 'Shandong',
            'city' => 'Jinan',
            'website' => 'https://www.l68.net',
        ]);

        $this->insert('{{%user_extend}}', [
            'user_id' => 1,
        ]);

        //给超级管理员授权
        $this->insert('{{%admin_auth_assignment}}', ['item_name' => 'Super Administrator', 'user_id' => 1, 'created_at' => time()]);

    }

    public function safeDown()
    {
        //$this->dropTable('{{%test}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M170911054507Add_test_user cannot be reverted.\n";

        return false;
    }
    */
}
