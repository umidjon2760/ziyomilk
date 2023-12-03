<?php

use yii\db\Migration;

/**
 * Handles the creation of table `expense_spr`.
 */
class m231005_061736_create_expense_spr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('expense_spr', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->unique()->notNull(),
            'name' => $this->string(255)->notNull(),
            'type' => $this->string(50)->notNull()->defaultValue('xarajat'),
            'product_code' => $this->string(50)->notNull(),
            'status' => $this->boolean()->defaultValue(true),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('expense_spr');
    }
}
