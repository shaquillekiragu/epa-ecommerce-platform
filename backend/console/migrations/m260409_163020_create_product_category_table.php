<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_category}}`.
 */
class m260409_163020_create_product_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%product_category}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%product_category}}', 'category_name', 'varchar(255) NOT NULL');
        $this->addColumn('{{%product_category}}', 'description', 'varchar(255) NOT NULL');
        $this->addColumn('{{%product_category}}', 'thumbnail', 'varchar(255) NULL');

        $this->addColumn('{{%product_category}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%product_category}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%product_category}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%product_category}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_product_category_name_unique', '{{%product_category}}', 'category_name', true);
        $this->createIndex('idx_product_category_created_by', '{{%product_category}}', 'created_by');
        $this->createIndex('idx_product_category_last_updated_by', '{{%product_category}}', 'last_updated_by');

        $this->addForeignKey('fk_product_category_created_by', '{{%product_category}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_product_category_last_updated_by', '{{%product_category}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_category}}');
    }
}

