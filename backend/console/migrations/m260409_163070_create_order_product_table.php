<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_product}}`.
 */
class m260409_163070_create_order_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%order_product}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%order_product}}', 'product_id', 'int NOT NULL');
        $this->addColumn('{{%order_product}}', 'order_id', 'int NOT NULL');
        $this->addColumn('{{%order_product}}', 'price_at_purchase_in_gbp', 'float NOT NULL');
        $this->addColumn('{{%order_product}}', 'quantity', 'int NOT NULL');

        $this->addColumn('{{%order_product}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%order_product}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%order_product}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%order_product}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_order_product_product_id', '{{%order_product}}', 'product_id');
        $this->createIndex('idx_order_product_order_id', '{{%order_product}}', 'order_id');
        $this->createIndex('idx_order_product_unique_pair', '{{%order_product}}', ['order_id', 'product_id'], true);
        $this->createIndex('idx_order_product_created_by', '{{%order_product}}', 'created_by');
        $this->createIndex('idx_order_product_last_updated_by', '{{%order_product}}', 'last_updated_by');

        $this->addForeignKey('fk_order_product_product', '{{%order_product}}', 'product_id', '{{%product}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_order_product_order', '{{%order_product}}', 'order_id', '{{%order}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_order_product_created_by', '{{%order_product}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_order_product_last_updated_by', '{{%order_product}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_product}}');
    }
}

