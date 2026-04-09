<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m260409_163060_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        // "order" is reserved; Yii quotes it via {{%order}}
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%order}}', 'customer_id', 'int NOT NULL');
        $this->addColumn('{{%order}}', 'store_id', 'int NOT NULL');
        $this->addColumn('{{%order}}', 'price_total', 'int NOT NULL');
        $this->addColumn('{{%order}}', 'order_datetime', 'datetime NOT NULL');
        $this->addColumn('{{%order}}', 'status', 'enum("pending_payment", "payment_failed", "paid", "shipped", "delivered", "cancelled", "refunded") NOT NULL');

        $this->addColumn('{{%order}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%order}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%order}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%order}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_order_customer_id', '{{%order}}', 'customer_id');
        $this->createIndex('idx_order_store_id', '{{%order}}', 'store_id');
        $this->createIndex('idx_order_status', '{{%order}}', 'status');
        $this->createIndex('idx_order_created_by', '{{%order}}', 'created_by');
        $this->createIndex('idx_order_last_updated_by', '{{%order}}', 'last_updated_by');

        $this->addForeignKey('fk_order_customer', '{{%order}}', 'customer_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_order_store', '{{%order}}', 'store_id', '{{%store}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_order_created_by', '{{%order}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_order_last_updated_by', '{{%order}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}

