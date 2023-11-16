<?php

use yii\db\Migration;

/**
 * Handles the creation of table `all_materials`.
 */
class m231116_060910_create_all_materials_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('all_materials', [
            'id' => $this->primaryKey(),
            'expense_code' => $this->string(50)->notNull(),
            'count' => $this->float(),
            'day' => $this->date(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('all_materials_expense_spr_fk','all_materials','expense_code','expense_spr','code');
        $this->addForeignKey('all_materials_days_fk','all_materials','day','days','day');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('all_materials');
    }
}
