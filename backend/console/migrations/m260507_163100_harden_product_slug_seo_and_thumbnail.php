<?php

use yii\db\Migration;

/**
 * Ensures product fields are never null and expands thumbnail size.
 *
 * - product.slug NOT NULL
 * - product.seo_title NOT NULL
 * - product.thumbnail expanded to TEXT (MySQL ~= VARCHAR(65535))
 * - backfills existing NULLs before tightening constraints
 */
class m260507_163100_harden_product_slug_seo_and_thumbnail extends Migration
{
    public function safeUp()
    {
        // Backfill slug/seo_title for existing rows.
        // Note: best-effort; application layer will compute more consistently going forward.
        $rows = (new \yii\db\Query())
            ->select(['id', 'name', 'sku_code', 'slug', 'seo_title'])
            ->from('{{%product}}')
            ->all($this->db);

        foreach ($rows as $row) {
            $id = (int) $row['id'];
            $name = trim((string) ($row['name'] ?? ''));
            $sku = trim((string) ($row['sku_code'] ?? ''));
            $slug = trim((string) ($row['slug'] ?? ''));
            $seo = trim((string) ($row['seo_title'] ?? ''));

            if ($seo === '') {
                $seo = mb_substr(($name !== '' ? $name : $sku), 0, 255);
                $this->update('{{%product}}', ['seo_title' => $seo], ['id' => $id]);
            }

            if ($slug === '') {
                // Match application slug format:
                // "<hyphenated-lowercase-name>-<sku_code>" (sku_code appended as-is).
                $name_part = mb_strtolower($name);
                $name_part = preg_replace('/[^a-z0-9]+/i', '-', $name_part) ?? '';
                $name_part = trim($name_part, '-');

                $base = $name_part !== '' ? ($name_part . '-' . $sku) : $sku;
                $slug = mb_substr($base !== '' ? $base : ('sku-' . $id), 0, 255);

                $this->update('{{%product}}', ['slug' => $slug], ['id' => $id]);
            }
        }

        // Expand thumbnail to allow long URLs.
        $this->alterColumn('{{%product}}', 'thumbnail', $this->text()->notNull());

        // Tighten slug + seo_title to NOT NULL.
        $this->alterColumn('{{%product}}', 'slug', $this->string(255)->notNull());
        $this->alterColumn('{{%product}}', 'seo_title', $this->string(255)->notNull());
    }

    public function safeDown()
    {
        // Revert constraints (may truncate long thumbnails).
        $this->alterColumn('{{%product}}', 'seo_title', $this->string(255)->null());
        $this->alterColumn('{{%product}}', 'slug', $this->string(255)->null());
    }
}
