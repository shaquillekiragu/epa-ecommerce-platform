<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%store}}`.
 */
class m260409_163010_create_store_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%store}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%store}}', 'store_name', 'varchar(255) NOT NULL');
        $this->addColumn('{{%store}}', 'store_description', 'varchar(255) NOT NULL');
        $this->addColumn('{{%store}}', 'merchant_id', 'int NOT NULL');

        $this->addColumn('{{%store}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%store}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%store}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%store}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_store_name_unique', '{{%store}}', 'store_name', true);
        $this->createIndex('idx_store_description_unique', '{{%store}}', 'store_description', true);
        $this->createIndex('idx_store_merchant_id', '{{%store}}', 'merchant_id');
        $this->createIndex('idx_store_created_by', '{{%store}}', 'created_by');
        $this->createIndex('idx_store_last_updated_by', '{{%store}}', 'last_updated_by');

        $this->addForeignKey('fk_store_merchant', '{{%store}}', 'merchant_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_store_created_by', '{{%store}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_store_last_updated_by', '{{%store}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%store}}');
    }
}

