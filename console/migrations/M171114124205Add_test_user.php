<?php

namespace app\migrations;

use yii\db\Migration;

class M171114124205Add_test_user extends Migration
{

    public function safeUp()
    {
        $time = time();
        $users = [];
        $profiles = [];
        $extends = [];
        for ($i = 1; $i <= 100; $i++) {
            $username = $nickname = 'user' . $i;
            $email = 'user' . $i . '@example.com';
            if ($i < 10) {
                $mobile = '1380013800' . $i;
            } else if ($i < 100) {
                $mobile = '138001380' . $i;
            } else {
                $mobile = '13800138' . $i;
            }

            $users[] = [$i, $username, $username, $email, $mobile, '0B8C1dRH1XxKhO15h_9JzaN0OAY9WprZ','0B8C1dRH1XxKhO15h_9JzaN0OAY9WprZ', '$2y$13$BzPeMPVIFLkiZXwkjJ/HZu0o6Mk0EUQdePC0ufnpzJCzIb4sOrUKK', $time, $time, $time, $time,];
            $profiles[] = ['user_id' => $i, 'gender' => 0, 'mobile' => $mobile, 'email' => $email, 'country' => 'CN', 'province' => 'Shandong', 'city' => 'Jinan', 'website' => 'https://www.l68.net',];
            $extends[] = [$i];
        }
        $this->batchInsert('{{%user}}', ['id', 'username', 'nickname', 'email', 'mobile', 'auth_key', 'access_token',  'password_hash', 'email_confirmed_at', 'mobile_confirmed_at', 'created_at', 'updated_at',], $users);
        $this->batchInsert('{{%user_profile}}', ['user_id', 'gender', 'mobile', 'email', 'country', 'province', 'city', 'website',], $profiles);
        $this->batchInsert('{{%user_extra}}', ['user_id',], $extends);
    }

    public function safeDown()
    {
       // $this->dropTable('{{%test}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171114124205Add_test_user cannot be reverted.\n";

        return false;
    }
    */
}
