<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m260409_155325_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%user}}', 'role', 'enum("customer", "merchant") NOT NULL DEFAULT "customer"');
        $this->addColumn('{{%user}}', 'first_name', 'varchar(255) NOT NULL');
        $this->addColumn('{{%user}}', 'middle_names', 'varchar(255) NULL');
        $this->addColumn('{{%user}}', 'last_name', 'varchar(255) NOT NULL');

        $this->addColumn('{{%user}}', 'email', 'varchar(255) NOT NULL');
        $this->addColumn('{{%user}}', 'hashed_password', 'varchar(255) NOT NULL');
        $this->addColumn('{{%user}}', 'date_of_birth', 'date NOT NULL');
        $this->addColumn('{{%user}}', 'country', 'varchar(255) NOT NULL');
        $this->addColumn('{{%user}}', 'mobile_number', 'varchar(20) NOT NULL');

        $this->addColumn('{{%user}}', 'is_account_active', 'boolean NOT NULL DEFAULT true');
        $this->addColumn('{{%user}}', 'deleted_at', 'timestamp NULL');

        // Self-referencing audit fields: nullable so the first user can be inserted
        $this->addColumn('{{%user}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%user}}', 'created_by', 'int NULL');
        $this->addColumn('{{%user}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%user}}', 'last_updated_by', 'int NULL');

        $this->createIndex('idx_user_email_unique', '{{%user}}', 'email', true);

        $this->addForeignKey('fk_user_created_by', '{{%user}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');
        $this->addForeignKey('fk_user_last_updated_by', '{{%user}}', 'last_updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
