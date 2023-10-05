<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products`.
 */
class m231005_050804_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->unique()->notNull(),
            'name' => $this->string(255)->notNull(),
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
        $this->dropTable('products');
    }
}
