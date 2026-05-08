<?php

use yii\base\UserException;
use yii\db\Migration;

/**
 * Product catalog indexes:
 * - Drops unique(name) so duplicate product names are allowed.
 * - Enforces unique (store_id, sku_code) via idx_product_store_sku_unique.
 * - Replaces legacy idx_product_sku_code_unique (global SKU) or non-unique idx_product_sku_code when present.
 * Idempotent: safe to re-run assuming data passes the duplicate check.
 */
class m260508_120000_product_unique_store_sku_and_drop_name_unique extends Migration
{
    public function safeUp()
    {
        $schema = $this->db->getTableSchema('{{%product}}', true);
        
        if ($schema === null) {
            return;
        }

        $quotedTable = $this->db->quoteTableName($schema->name);

        $dupPair = (int) $this->db->createCommand(
            "SELECT COUNT(*) FROM (SELECT 1 FROM {$quotedTable} GROUP BY store_id, sku_code HAVING COUNT(*) > 1) t"
        )->queryScalar();

        if ($dupPair > 0) {
            throw new UserException(
                'Cannot enforce unique (store_id, sku_code): duplicate rows exist in product. Fix data then re-run migrations.'
            );
        }

        if ($this->indexExistsOnProduct('idx_product_name_unique')) {
            $this->dropIndex('idx_product_name_unique', '{{%product}}');
        }

        if ($this->indexExistsOnProduct('idx_product_sku_code_unique')) {
            $this->dropIndex('idx_product_sku_code_unique', '{{%product}}');
        }

        if ($this->indexExistsOnProduct('idx_product_store_sku_unique')) {
            $this->dropIndex('idx_product_store_sku_unique', '{{%product}}');
        }

        if ($this->indexExistsOnProduct('idx_product_sku_code')) {
            $this->dropIndex('idx_product_sku_code', '{{%product}}');
        }

        if (!$this->indexExistsOnProduct('idx_product_store_sku_unique')) {
            $this->createIndex('idx_product_store_sku_unique', '{{%product}}', ['store_id', 'sku_code'], true);
        }
    }

    public function safeDown()
    {
        if ($this->db->getTableSchema('{{%product}}', true) === null) {
            return;
        }

        if ($this->indexExistsOnProduct('idx_product_store_sku_unique')) {
            $this->dropIndex('idx_product_store_sku_unique', '{{%product}}');
        }

        if (!$this->indexExistsOnProduct('idx_product_sku_code')) {
            $this->createIndex('idx_product_sku_code', '{{%product}}', 'sku_code');
        }

        // Do not restore unique(name); catalog allows duplicate product names.
    }

    private function indexExistsOnProduct(string $keyName): bool
    {
        $schema = $this->db->getTableSchema('{{%product}}', true);
        if ($schema === null) {
            return false;
        }

        $quotedTable = $this->db->quoteTableName($schema->name);
        $row = $this->db->createCommand(
            "SHOW INDEX FROM {$quotedTable} WHERE Key_name = :k",
            [':k' => $keyName]
        )->queryOne();

        return $row !== false && $row !== null;
    }
}
