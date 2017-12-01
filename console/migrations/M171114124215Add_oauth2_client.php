<?php

namespace app\migrations;

use yii\db\Migration;

class M171114124215Add_oauth2_client extends Migration
{

    public function safeUp()
    {
        $this->insert('{{%oauth2_client}}', [
            'client_id' => 100000,
            'client_secret' => 'Dj4BBEqsDuL-g9m4mZKHRw3wydGvm7N0',
            'user_id' => 1,
            'redirect_uri' => 'https://www.getpostman.com/oauth2/callback',
            'grant_type' => NULL,
            'scope' => NULL,
            'name' => 'App',
            'domain' => 'sixiang.im',
            'provider' => '济南智数信息科技有限公司',
            'icp' => '鲁ICP备16044693号-6',
            'registration_ip' => '112.230.206.38',
            'created_at' => 1503631239,
            'updated_at' => 1503631239,
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%oauth2_client}}', ['client_id' => 100000]);
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171114124215Add_oauth2_client cannot be reverted.\n";

        return false;
    }
    */
}
