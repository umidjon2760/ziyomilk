<?php

use yii\db\Migration;

/**
 * Handles the creation of table `loans`.
 */
class m231008_101410_create_loans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('loans', [
            'id' => $this->primaryKey(),
            'expense_id' => $this->integer(),
            'loan_sum' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('loans_expenses_fk','loans','expense_id','expenses','id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('loans');
    }
}
