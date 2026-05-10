<?php

use yii\db\Migration;
use yii\db\Query;
use yii\helpers\Inflector;

/**
 * Removes CatalogSeeder date prefix from product.name (seed_YYYYMMDD_HHMMSS_).
 * Refreshes seo_title and slug to match Product::beforeValidate() output for consistency.
 */
class m260508_140000_strip_seed_prefix_from_product_names extends Migration
{
    private const NAME_PREFIX_PATTERN = '/^seed_\d{8}_\d{6}_/u';

    public function safeUp()
    {
        $schema = $this->db->getTableSchema('{{%product}}', true);
        if ($schema === null) {
            return;
        }

        $query = (new Query())
            ->select(['id', 'name', 'sku_code'])
            ->from('{{%product}}');

        foreach ($query->each(100, $this->db) as $row) {
            $oldName = (string) $row['name'];
            $newName = preg_replace(self::NAME_PREFIX_PATTERN, '', $oldName);
            if ($newName === $oldName) {
                continue;
            }

            $sku = (string) $row['sku_code'];
            $seoTitle = mb_substr($newName !== '' ? $newName : $sku, 0, 255);
            $nameSlug = Inflector::slug($newName);
            $base = $nameSlug !== '' ? ($nameSlug . '-' . $sku) : $sku;
            $slug = mb_substr($base, 0, 255);

            $this->update(
                '{{%product}}',
                [
                    'name' => $newName,
                    'seo_title' => $seoTitle,
                    'slug' => $slug,
                ],
                ['id' => (int) $row['id']]
            );
        }
    }

    public function safeDown()
    {
        // Irreversible: original prefix timestamps are not stored.
    }
}
