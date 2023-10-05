<?php

use yii\db\Migration;

/**
 * Handles the creation of table `all_products`.
 */
class m231005_080839_create_all_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('all_products', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(50)->notNull(),
            'count' => $this->integer(),
            'day' => $this->date(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('all_products_products_fk','all_products','product_code','products','code');
        $this->addForeignKey('all_products_days_fk','all_products','day','days','day');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('all_products');
    }
}
