<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%basket_product}}`.
 */
class m260409_163050_create_basket_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%basket_product}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%basket_product}}', 'product_id', 'int NOT NULL');
        $this->addColumn('{{%basket_product}}', 'basket_id', 'int NOT NULL');
        $this->addColumn('{{%basket_product}}', 'quantity', 'int NOT NULL');

        $this->addColumn('{{%basket_product}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%basket_product}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%basket_product}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%basket_product}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_basket_product_product_id', '{{%basket_product}}', 'product_id');
        $this->createIndex('idx_basket_product_basket_id', '{{%basket_product}}', 'basket_id');
        $this->createIndex('idx_basket_product_unique_pair', '{{%basket_product}}', ['basket_id', 'product_id'], true);
        $this->createIndex('idx_basket_product_created_by', '{{%basket_product}}', 'created_by');
        $this->createIndex('idx_basket_product_last_updated_by', '{{%basket_product}}', 'last_updated_by');

        $this->addForeignKey('fk_basket_product_product', '{{%basket_product}}', 'product_id', '{{%product}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_basket_product_basket', '{{%basket_product}}', 'basket_id', '{{%basket}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_basket_product_created_by', '{{%basket_product}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_basket_product_last_updated_by', '{{%basket_product}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%basket_product}}');
    }
}
