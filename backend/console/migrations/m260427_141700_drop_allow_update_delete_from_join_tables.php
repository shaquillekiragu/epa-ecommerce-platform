<?php

use yii\db\Migration;

/**
 * Drops allow_update and allow_delete flags from join/linkup tables.
 *
 * These tables are modeled as link tables and shouldn't expose update/delete
 * permission flags as part of the domain.
 */
class m260427_141700_drop_allow_update_delete_from_join_tables extends Migration
{
    public function safeUp()
    {
        $tables = [
            '{{%basket_product}}',
            '{{%order_product}}',
            '{{%user_address}}',
        ];

        foreach ($tables as $table) {
            if ($this->db->schema->getTableSchema($table, true) === null) {
                continue;
            }

            $schema = $this->db->schema->getTableSchema($table, true);

            if (isset($schema->columns['allow_delete'])) {
                $this->dropColumn($table, 'allow_delete');
            }

            if (isset($schema->columns['allow_update'])) {
                $this->dropColumn($table, 'allow_update');
            }
        }
    }

    public function safeDown()
    {
        $tables = [
            '{{%basket_product}}',
            '{{%order_product}}',
            '{{%user_address}}',
        ];

        foreach ($tables as $table) {
            if ($this->db->schema->getTableSchema($table, true) === null) {
                continue;
            }

            $schema = $this->db->schema->getTableSchema($table, true);

            if (!isset($schema->columns['allow_update'])) {
                $this->addColumn($table, 'allow_update', $this->boolean()->notNull()->defaultValue(true));
            }

            if (!isset($schema->columns['allow_delete'])) {
                $this->addColumn($table, 'allow_delete', $this->boolean()->notNull()->defaultValue(true));
            }
        }
    }
}

