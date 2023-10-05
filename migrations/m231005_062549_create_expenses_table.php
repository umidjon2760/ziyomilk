<?php

use yii\db\Migration;

/**
 * Handles the creation of table `expenses`.
 */
class m231005_062549_create_expenses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('expenses', [
            'id' => $this->primaryKey(),
            'expense_code' => $this->string(50)->notNull(),
            'sum' => $this->float(),
            'day' => $this->date(),
            'count' => $this->integer(),
            'all_sum' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('expenses_expense_spr_fk','expenses','expense_code','expense_spr','code');
        $this->addForeignKey('expenses_days_fk','expenses','day','days','day');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('expenses');
    }
}
