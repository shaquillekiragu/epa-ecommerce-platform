<?php

use yii\db\Migration;

/**
 * Makes last_updated_at NULL on creation and auto-updated by DB on updates.
 *
 * Changes last_updated_at to:
 *   TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
 */
class m260428_153500_make_last_updated_at_nullable extends Migration
{
    /**
     * @var string[]
     */
    private array $tables = [
        '{{%user}}',
        '{{%address}}',
        '{{%store}}',
        '{{%product_category}}',
        '{{%product}}',
        '{{%basket}}',
        '{{%basket_product}}',
        '{{%order}}',
        '{{%order_product}}',
        '{{%user_address}}',
    ];

    public function safeUp()
    {
        foreach ($this->tables as $table) {
            $schema = $this->db->schema->getTableSchema($table, true);
            if ($schema === null || !isset($schema->columns['last_updated_at'])) {
                continue;
            }

            // MySQL-specific column definition used throughout this project migrations.
            $this->alterColumn($table, 'last_updated_at', 'timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP');
        }
    }

    public function safeDown()
    {
        foreach ($this->tables as $table) {
            $schema = $this->db->schema->getTableSchema($table, true);
            if ($schema === null || !isset($schema->columns['last_updated_at'])) {
                continue;
            }

            $this->alterColumn($table, 'last_updated_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        }
    }
}
