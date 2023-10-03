<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m231003_180513_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull(),
            'password' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'phone' => $this->integer(12)->notNull(),
            'address' => $this->string(255),
            'email' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
