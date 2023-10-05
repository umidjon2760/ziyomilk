<?php

use yii\db\Migration;

/**
 * Handles the creation of table `days`.
 */
class m231005_052224_create_days_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('days', [
            'id' => $this->primaryKey(),
            'day' => $this->date()->unique(),
            'status' => $this->boolean()->defaultValue(false),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('days');
    }
}
