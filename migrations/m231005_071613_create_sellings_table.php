<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sellings`.
 */
class m231005_071613_create_sellings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sellings', [
            'id' => $this->primaryKey(),
            'diller_id' => $this->integer(),
            'product_code' => $this->string(50)->notNull(),
            'day' => $this->date(),
            'buy' => $this->float(),
            'return' => $this->float()->defaultValue(0),
            'all_sum' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('sellings_dillers_fk','sellings','diller_id','dillers','id');
        $this->addForeignKey('sellings_days_fk','sellings','day','days','day');
        $this->addForeignKey('sellings_products_fk','sellings','product_code','products','code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sellings');
    }
}
