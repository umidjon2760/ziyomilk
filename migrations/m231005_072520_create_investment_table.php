<?php

use yii\db\Migration;

/**
 * Handles the creation of table `investment`.
 */
class m231005_072520_create_investment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('investment', [
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
        $this->dropTable('investment');
    }
}
