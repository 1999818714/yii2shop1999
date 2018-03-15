<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m180309_033412_create_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->comment('用户名'),
            'password' => $this->string(100)->comment('密码(密文)'),
            'tel' => $this->string(11)->comment('手机号码'),
            'email' => $this->string(100)->comment('邮箱'),
            'last_login_time' => $this->integer()->comment('最后登录时间'),
            'last_login_ip' =>$this->integer()->comment('最后登录IP'),
            'status' =>$this->string()->comment('状态（1正常，0删除）'),
            'auth_key'=>$this->string(32)->comment('令牌'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('member');
    }
}
