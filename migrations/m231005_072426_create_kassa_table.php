<?php

use yii\db\Migration;

/**
 * Handles the creation of table `kassa`.
 */
class m231005_072426_create_kassa_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('kassa', [
            'id' => $this->primaryKey(),
            'day' => $this->date(),
            'sum' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('kassa');
    }
}
