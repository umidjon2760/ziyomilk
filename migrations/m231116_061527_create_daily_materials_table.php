<?php

use yii\db\Migration;

/**
 * Handles the creation of table `daily_materials`.
 */
class m231116_061527_create_daily_materials_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('daily_materials', [
            'id' => $this->primaryKey(),
            'expense_code' => $this->string(50)->notNull(),
            'count' => $this->float(),
            'day' => $this->date(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('daily_materials_expense_spr_fk','daily_materials','expense_code','expense_spr','code');
        $this->addForeignKey('daily_materials_days_fk','daily_materials','day','days','day');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('daily_materials');
    }
}
