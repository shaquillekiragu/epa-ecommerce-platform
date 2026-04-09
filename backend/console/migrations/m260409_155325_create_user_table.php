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

            'role' => "ENUM('customer','merchant') NOT NULL",

            'first_name' => $this->string(255)->notNull(),
            'middle_names' => $this->string(255)->null(),
            'last_name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'hashed_password' => $this->string(255)->notNull(),
            'date_of_birth' => $this->date()->notNull(),
            'country' => $this->string(255)->notNull(),
            'mobile_number' => $this->string(20)->notNull(),

            'is_account_active' => $this->boolean()->notNull()->defaultValue(true),
            'deleted_at' => $this->timestamp()->null(),

            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->null(), // see note above
            'last_updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'last_updated_by' => $this->integer()->null(), // see note above
        ], $tableOptions);

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
