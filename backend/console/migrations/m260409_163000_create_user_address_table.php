<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_address}}`.
 */
class m260409_163000_create_user_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%user_address}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);

        $this->addColumn('{{%user_address}}', 'user_id', 'int NOT NULL');
        $this->addColumn('{{%user_address}}', 'address_id', 'int NOT NULL');

        $this->addColumn('{{%user_address}}', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('{{%user_address}}', 'created_by', 'int NOT NULL');
        $this->addColumn('{{%user_address}}', 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->addColumn('{{%user_address}}', 'last_updated_by', 'int NOT NULL');

        $this->createIndex('idx_user_address_user_id', '{{%user_address}}', 'user_id');
        $this->createIndex('idx_user_address_address_id', '{{%user_address}}', 'address_id');
        $this->createIndex('idx_user_address_unique_pair', '{{%user_address}}', ['user_id', 'address_id'], true);
        $this->createIndex('idx_user_address_created_by', '{{%user_address}}', 'created_by');
        $this->createIndex('idx_user_address_last_updated_by', '{{%user_address}}', 'last_updated_by');

        $this->addForeignKey('fk_user_address_user', '{{%user_address}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_user_address_address', '{{%user_address}}', 'address_id', '{{%address}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_user_address_created_by', '{{%user_address}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_user_address_last_updated_by', '{{%user_address}}', 'last_updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_address}}');
    }
}
