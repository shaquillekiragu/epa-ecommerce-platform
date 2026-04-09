<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m260409_162233_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%address}}', 'address_type', 'enum("shipping", "billing") NOT NULL DEFAULT "shipping"');

        $this->addColumn('{{%address}}', 'building_number', 'varchar(255) NOT NULL');
        $this->addColumn('{{%address}}', 'street_name', 'varchar(255) NOT NULL');
        $this->addColumn('{{%address}}', 'city', 'varchar(255) NOT NULL');
        $this->addColumn('{{%address}}', 'region', 'varchar(255) NULL');
        $this->addColumn('{{%address}}', 'country', 'varchar(255) NOT NULL');
        $this->addColumn('{{%address}}', 'post_code', 'varchar(255) NOT NULL');

        $this->addColumn('{{%address}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%address}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%address}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%address}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_address_created_by', '{{%address}}', 'created_by');
        $this->createIndex('idx_address_last_updated_by', '{{%address}}', 'last_updated_by');

        $this->addForeignKey('fk_address_created_by', '{{%address}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_address_last_updated_by', '{{%address}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
