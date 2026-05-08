<?php

use yii\base\UserException;
use yii\db\Migration;

/**
 * Store name is unique per merchant (merchant_id, name), not globally.
 */
class m260508_130000_store_unique_merchant_name extends Migration
{
    public function safeUp()
    {
        $schema = $this->db->getTableSchema('{{%store}}', true);
        if ($schema === null) {
            return;
        }

        $quotedTable = $this->db->quoteTableName($schema->name);
        $dupPair = (int) $this->db->createCommand(
            "SELECT COUNT(*) FROM (SELECT 1 FROM {$quotedTable} GROUP BY merchant_id, name HAVING COUNT(*) > 1) t"
        )->queryScalar();

        if ($dupPair > 0) {
            throw new UserException(
                'Cannot enforce unique (merchant_id, name): duplicate rows exist in store. Fix data then re-run migrations.'
            );
        }

        if ($this->indexExistsOnStore('idx_store_name_unique')) {
            $this->dropIndex('idx_store_name_unique', '{{%store}}');
        }

        if ($this->indexExistsOnStore('idx_store_merchant_name_unique')) {
            $this->dropIndex('idx_store_merchant_name_unique', '{{%store}}');
        }

        if (!$this->indexExistsOnStore('idx_store_merchant_name_unique')) {
            $this->createIndex('idx_store_merchant_name_unique', '{{%store}}', ['merchant_id', 'name'], true);
        }
    }

    public function safeDown()
    {
        if ($this->db->getTableSchema('{{%store}}', true) === null) {
            return;
        }

        if ($this->indexExistsOnStore('idx_store_merchant_name_unique')) {
            $this->dropIndex('idx_store_merchant_name_unique', '{{%store}}');
        }

        if (!$this->indexExistsOnStore('idx_store_name_unique')) {
            $this->createIndex('idx_store_name_unique', '{{%store}}', 'name', true);
        }
    }

    private function indexExistsOnStore(string $keyName): bool
    {
        $schema = $this->db->getTableSchema('{{%store}}', true);
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
