<?php

use yii\db\Migration;

/**
 * Handles the creation of table `productions`.
 */
class m231005_071037_create_productions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('productions', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(50)->notNull(),
            'count' => $this->integer(),
            'day' => $this->date(),
            'price' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('productions_products_fk','productions','product_code','products','code');
        $this->addForeignKey('productions_days_fk','productions','day','days','day');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('productions');
    }
}
