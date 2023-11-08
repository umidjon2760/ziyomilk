<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dillers_calc`.
 */
class m231008_133139_create_dillers_calc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dillers_calc', [
            'id' => $this->primaryKey(),
            'diller_id' => $this->integer()->notNull(),
            'given_sum' => $this->float(),
            'loan_sum' => $this->float(),
            'old_loan_sum' => $this->float(),
            'all_sum' => $this->float(),
            'day' => $this->date(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('dillers_calc_days_fk','dillers_calc','day','days','day');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dillers_calc');
    }
}
