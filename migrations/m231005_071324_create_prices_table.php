<?php

use yii\db\Migration;

/**
 * Handles the creation of table `prices`.
 */
class m231005_071324_create_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('prices', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(50)->notNull(),
            'price' => $this->float(),
            'status' => $this->boolean(),
            'photo' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('prices_products_fk','prices','product_code','products','code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('prices');
    }
}
