<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%basket}}`.
 */
class m260409_163040_create_basket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%basket}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%basket}}', 'customer_id', 'int NOT NULL');
        $this->addColumn('{{%basket}}', 'price_total', 'int NOT NULL');

        $this->addColumn('{{%basket}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%basket}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%basket}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%basket}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_basket_customer_id', '{{%basket}}', 'customer_id');
        $this->createIndex('idx_basket_created_by', '{{%basket}}', 'created_by');
        $this->createIndex('idx_basket_last_updated_by', '{{%basket}}', 'last_updated_by');

        $this->addForeignKey('fk_basket_customer', '{{%basket}}', 'customer_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_basket_created_by', '{{%basket}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_basket_last_updated_by', '{{%basket}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%basket}}');
    }
}
