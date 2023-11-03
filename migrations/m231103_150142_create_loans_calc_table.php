<?php

use yii\db\Migration;

/**
 * Handles the creation of table `loans_calc`.
 */
class m231103_150142_create_loans_calc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('loans_calc', [
            'id' => $this->primaryKey(),
            'loan_id' => $this->integer(),
            'given_sum' => $this->float(),
            'day' => $this->date(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('loans_calc_expenses_fk','loans_calc','loan_id','loans','id');
        $this->addForeignKey('loans_calc_days_fk','loans_calc','day','days','day');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('loans_calc');
    }
}
