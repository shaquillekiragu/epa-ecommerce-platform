<?php

use yii\db\Migration;

/**
 * Renames scalar columns that redundantly prefix the table name (FK columns unchanged).
 *
 * - product.product_name -> name
 * - store.store_name / store_description -> name / description
 * - product_category.category_name -> name
 * - order.order_datetime -> placed_at
 */
class m260501_170000_rename_redundant_table_prefixed_columns extends Migration
{
    public function safeUp()
    {
        $this->renameIfHas('{{%product}}', 'product_name', 'name');
        $this->renameIfHas('{{%store}}', 'store_name', 'name');
        $this->renameIfHas('{{%store}}', 'store_description', 'description');
        $this->renameIfHas('{{%product_category}}', 'category_name', 'name');
        $this->renameIfHas('{{%order}}', 'order_datetime', 'placed_at');
    }

    public function safeDown()
    {
        $this->renameIfHas('{{%order}}', 'placed_at', 'order_datetime');
        $this->renameIfHas('{{%product_category}}', 'name', 'category_name');
        $this->renameIfHas('{{%store}}', 'description', 'store_description');
        $this->renameIfHas('{{%store}}', 'name', 'store_name');
        $this->renameIfHas('{{%product}}', 'name', 'product_name');
    }

    private function renameIfHas(string $table, string $from, string $to): void
    {
        $schema = $this->db->getTableSchema($table, true);
        if ($schema === null) {
            return;
        }
        if (isset($schema->columns[$from]) && !isset($schema->columns[$to])) {
            $this->renameColumn($table, $from, $to);
        }
    }
}
