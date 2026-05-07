<?php

use yii\db\Migration;

/**
 * Enforces that product_category.name is non-empty and contains letters.
 *
 * - Backfills existing NULL/empty values
 * - Adds DB-level CHECK constraint where supported
 */
class m260507_154800_enforce_product_category_name_nonempty extends Migration
{
    public function safeUp()
    {
        // If the schema still uses category_name, rename it to name first.
        $schema = $this->db->getTableSchema('{{%product_category}}', true);
        if ($schema !== null && isset($schema->columns['category_name']) && !isset($schema->columns['name'])) {
            // Drop old unique index name if present before rename.
            try {
                $this->dropIndex('idx_product_category_name_unique', '{{%product_category}}');
            } catch (\Throwable $e) {
                // ignore
            }

            $this->renameColumn('{{%product_category}}', 'category_name', 'name');
        }

        // 1) Backfill NULL/empty name using description or fallback.
        $rows = (new \yii\db\Query())
            ->select(['id', 'name', 'description'])
            ->from('{{%product_category}}')
            ->all($this->db);

        foreach ($rows as $row) {
            $id = (int) $row['id'];
            $name = trim((string) ($row['name'] ?? ''));
            if ($name !== '') {
                continue;
            }

            $desc = trim((string) ($row['description'] ?? ''));
            $fallback = $desc !== '' ? $desc : ('Category ' . $id);

            $this->update('{{%product_category}}', ['name' => $fallback], ['id' => $id]);
        }

        // 2) Enforce non-empty at DB level (NOT NULL + CHECK).
        // (NOT NULL already exists in the create migration, but this keeps environments consistent.)
        $this->alterColumn('{{%product_category}}', 'name', $this->string(255)->notNull());

        // Ensure unique index exists on name.
        try {
            $this->createIndex('idx_product_category_name_unique', '{{%product_category}}', 'name', true);
        } catch (\Throwable $e) {
            // ignore
        }

        // MySQL 8+ enforces CHECK; older versions may ignore it, but it’s safe to add.
        // Ensure any existing constraint with the same name is removed first.
        $driver = $this->db->driverName;
        if ($driver === 'mysql') {
            // Drop if exists (MySQL 8 supports IF EXISTS; use try/catch for compatibility).
            try {
                $this->execute('ALTER TABLE `product_category` DROP CHECK `chk_product_category_name_has_letters`');
            } catch (\Throwable $e) {
                // ignore
            }

            $this->execute(
                "ALTER TABLE `product_category`
                 ADD CONSTRAINT `chk_product_category_name_has_letters`
                 CHECK (`name` REGEXP '[[:alpha:]]')"
            );
        }
    }

    public function safeDown()
    {
        if ($this->db->driverName === 'mysql') {
            try {
                $this->execute('ALTER TABLE `product_category` DROP CHECK `chk_product_category_name_has_letters`');
            } catch (\Throwable $e) {
                // ignore
            }
        }
        return true;
    }
}
