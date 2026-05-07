<?php

use yii\db\Migration;

class m260507_124500_create_user_token_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
            : null;

        $this->createTable('{{%user_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token_hash' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'expires_at' => $this->timestamp()->null(),
            'revoked_at' => $this->timestamp()->null(),
            'last_used_at' => $this->timestamp()->null(),
        ], $tableOptions);

        $this->createIndex('idx_user_token_user_id', '{{%user_token}}', 'user_id');
        $this->createIndex('idx_user_token_hash_unique', '{{%user_token}}', 'token_hash', true);

        $this->addForeignKey(
            'fk_user_token_user',
            '{{%user_token}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_token}}');
    }
}
