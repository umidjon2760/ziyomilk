<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dillers`.
 */
class m231005_041633_create_dillers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dillers', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255),
            'phone' => $this->integer(9),
            'phone2' => $this->integer(9),
            'tg_address' => $this->string(255),
            'car_number' => $this->string(10),
            'photo' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dillers');
    }
}
