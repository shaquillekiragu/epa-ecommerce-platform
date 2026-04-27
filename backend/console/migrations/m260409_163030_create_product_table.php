<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m260409_163030_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%product}}', 'store_id', 'int NOT NULL');
        $this->addColumn('{{%product}}', 'product_name', 'varchar(255) NOT NULL');
        $this->addColumn('{{%product}}', 'product_category_id', 'int NOT NULL');

        $this->addColumn('{{%product}}', 'price_in_gbp', 'float NOT NULL');
        $this->addColumn('{{%product}}', 'number_in_stock', 'int NOT NULL');
        $this->addColumn('{{%product}}', 'sku_code', 'varchar(64) NOT NULL');
        $this->addColumn('{{%product}}', 'weight_in_grams', 'int NOT NULL');
        $this->addColumn('{{%product}}', 'thumbnail', 'varchar(255) NOT NULL');
        $this->addColumn('{{%product}}', 'is_active', 'boolean NOT NULL DEFAULT true');

        $this->addColumn('{{%product}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%product}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%product}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%product}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_product_name_unique', '{{%product}}', 'product_name', true);
        $this->createIndex('idx_product_store_id', '{{%product}}', 'store_id');
        $this->createIndex('idx_product_category_id', '{{%product}}', 'product_category_id');
        $this->createIndex('idx_product_sku_code', '{{%product}}', 'sku_code');
        $this->createIndex('idx_product_created_by', '{{%product}}', 'created_by');
        $this->createIndex('idx_product_last_updated_by', '{{%product}}', 'last_updated_by');

        $this->addForeignKey('fk_product_store', '{{%product}}', 'store_id', '{{%store}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_product_category', '{{%product}}', 'product_category_id', '{{%product_category}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_product_created_by', '{{%product}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_product_last_updated_by', '{{%product}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
