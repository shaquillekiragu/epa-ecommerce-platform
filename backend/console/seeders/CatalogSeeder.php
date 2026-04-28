<?php

namespace console\seeders;

use yii\db\Query;
use yii\helpers\Console;

final class CatalogSeeder extends BaseSeeder
{
    /**
     * Seeds: store, product_category, product.
     *
     * Requires: at least one merchant user (store.merchant_id FK) and RBAC superadmin assignment (audit fields).
     */
    public function seed(int $debug = 1, int $batch_size = 25, int $count = 10): void
    {
        $actor_id = $this->getSuperadminUserId();
        if ($actor_id === null) {
            throw new \RuntimeException('No RBAC assignment found for role "superadmin". Seed/assign a superadmin user first.');
        }

        $merchant_ids = (new Query())
            ->select(['id'])
            ->from('{{%user}}')
            ->where(['role' => 'merchant'])
            ->orderBy(['id' => SORT_ASC])
            ->column($this->db);

        if (count($merchant_ids) === 0) {
            throw new \RuntimeException('No merchant users found. Seed users first.');
        }

        $stores = $this->applyAuditActor($this->buildStores($count, $merchant_ids, $this->seed_run_prefix), $actor_id);
        $categories = $this->applyAuditActor($this->buildCategories($count, $this->seed_run_prefix), $actor_id);

        $tx = $this->db->beginTransaction();

        try {
            $store_ids = $this->insertData(array_chunk($stores, $batch_size), 'store', true);
            $category_ids = $this->insertData(array_chunk($categories, $batch_size), 'product_category', true);

            $products = $this->applyAuditActor(
                $this->buildProducts($count, $store_ids, $category_ids, $this->seed_run_prefix),
                $actor_id
            );
            $product_ids = $this->insertData(array_chunk($products, $batch_size), 'product', true);

            $tx->commit();

            if ($debug === 1) {
                Console::output('Seed complete:');
                Console::output('- stores inserted: ' . count($store_ids));
                Console::output('- product categories inserted: ' . count($category_ids));
                Console::output('- products inserted: ' . count($product_ids));
            }
        } catch (\Throwable $e) {
            $tx->rollBack();
            throw $e;
        }
    }

    private function buildStores(int $count, array $merchant_ids, string $prefix): array
    {
        $rows = [
            ['store_name' => 'Northstar Goods', 'store_description' => 'Everyday essentials, done well.'],
            ['store_name' => 'Saffron & Steel', 'store_description' => 'Bold flavors and durable tools.'],
            ['store_name' => 'Harbor & Hearth', 'store_description' => 'Home comforts and coastal classics.'],
            ['store_name' => 'Cedarline Market', 'store_description' => 'Natural picks for modern living.'],
            ['store_name' => 'Metro Corner', 'store_description' => 'Fast-moving urban staples.'],
            ['store_name' => 'Sunrise Traders', 'store_description' => 'Seasonal favorites and daily deals.'],
            ['store_name' => 'Paper & Pixel', 'store_description' => 'Stationery and small tech accessories.'],
            ['store_name' => 'Verdant Supply', 'store_description' => 'Plants, pots, and green living.'],
            ['store_name' => 'Atlas Outlet', 'store_description' => 'Travel gear and practical carry.'],
            ['store_name' => 'Oak & Olive', 'store_description' => 'Kitchen basics with a premium feel.'],
        ];

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $merchant_id = $merchant_ids[$i % count($merchant_ids)];
            $rows[$i] = array_merge($row, [
                // store_name and store_description are unique in this schema; prefix per seed run.
                'store_name' => $prefix . $row['store_name'],
                'store_description' => $prefix . $row['store_description'],
                'merchant_id' => (int) $merchant_id,
                'allow_update' => 1,
                'allow_delete' => 1,
                'created_by' => null,
                'last_updated_by' => null,
            ]);
        }

        return $rows;
    }

    private function buildCategories(int $count, string $prefix): array
    {
        $rows = [
            ['category_name' => 'Home & Kitchen', 'description' => 'Tools and essentials for daily home life.', 'thumbnail' => null],
            ['category_name' => 'Electronics', 'description' => 'Accessories and handy devices.', 'thumbnail' => null],
            ['category_name' => 'Beauty', 'description' => 'Personal care and grooming.', 'thumbnail' => null],
            ['category_name' => 'Sports', 'description' => 'Fitness and outdoor gear.', 'thumbnail' => null],
            ['category_name' => 'Books', 'description' => 'Reading and stationery.', 'thumbnail' => null],
            ['category_name' => 'Toys', 'description' => 'Games and fun for all ages.', 'thumbnail' => null],
            ['category_name' => 'Grocery', 'description' => 'Pantry items and snacks.', 'thumbnail' => null],
            ['category_name' => 'Fashion', 'description' => 'Everyday wear and accessories.', 'thumbnail' => null],
            ['category_name' => 'Garden', 'description' => 'Plants and garden supplies.', 'thumbnail' => null],
            ['category_name' => 'Office', 'description' => 'Workspace essentials.', 'thumbnail' => null],
        ];

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $rows[$i] = array_merge($row, [
                // category_name is unique in this schema; prefix per seed run.
                'category_name' => $prefix . $row['category_name'],
                'allow_update' => 1,
                'allow_delete' => 1,
                'created_by' => null,
                'last_updated_by' => null,
            ]);
        }

        return $rows;
    }

    private function buildProducts(int $count, array $store_ids, array $category_ids, string $prefix): array
    {
        $rows = [
            ['product_name' => 'Stainless Water Bottle', 'price_in_gbp' => 14.99, 'number_in_stock' => 120, 'sku_code' => 'SKU-WB-0001', 'weight_in_grams' => 320, 'thumbnail' => 'water-bottle.jpg'],
            ['product_name' => 'Ceramic Coffee Mug', 'price_in_gbp' => 9.50, 'number_in_stock' => 200, 'sku_code' => 'SKU-MUG-0002', 'weight_in_grams' => 410, 'thumbnail' => 'coffee-mug.jpg'],
            ['product_name' => 'USB-C Cable 2m', 'price_in_gbp' => 7.99, 'number_in_stock' => 500, 'sku_code' => 'SKU-USBC-0003', 'weight_in_grams' => 80, 'thumbnail' => 'usb-c-cable.jpg'],
            ['product_name' => 'Notebook A5 (Dotted)', 'price_in_gbp' => 6.49, 'number_in_stock' => 350, 'sku_code' => 'SKU-NB-0004', 'weight_in_grams' => 250, 'thumbnail' => 'notebook.jpg'],
            ['product_name' => 'Wireless Mouse', 'price_in_gbp' => 19.95, 'number_in_stock' => 160, 'sku_code' => 'SKU-MSE-0005', 'weight_in_grams' => 110, 'thumbnail' => 'mouse.jpg'],
            ['product_name' => 'Kitchen Knife Set', 'price_in_gbp' => 39.00, 'number_in_stock' => 80, 'sku_code' => 'SKU-KNF-0006', 'weight_in_grams' => 900, 'thumbnail' => 'knife-set.jpg'],
            ['product_name' => 'Resistance Bands', 'price_in_gbp' => 11.25, 'number_in_stock' => 240, 'sku_code' => 'SKU-RB-0007', 'weight_in_grams' => 180, 'thumbnail' => 'bands.jpg'],
            ['product_name' => 'LED Desk Lamp', 'price_in_gbp' => 24.75, 'number_in_stock' => 95, 'sku_code' => 'SKU-LMP-0008', 'weight_in_grams' => 650, 'thumbnail' => 'desk-lamp.jpg'],
            ['product_name' => 'Organic Snack Pack', 'price_in_gbp' => 12.00, 'number_in_stock' => 300, 'sku_code' => 'SKU-SNK-0009', 'weight_in_grams' => 450, 'thumbnail' => 'snack-pack.jpg'],
            ['product_name' => 'Mini Tool Kit', 'price_in_gbp' => 17.80, 'number_in_stock' => 140, 'sku_code' => 'SKU-TK-0010', 'weight_in_grams' => 520, 'thumbnail' => 'tool-kit.jpg'],
        ];

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $rows[$i] = array_merge($row, [
                // product_name is unique, and sku_code has a unique index; prefix per seed run.
                'product_name' => $prefix . $row['product_name'],
                'sku_code' => $prefix . $row['sku_code'],
                'store_id' => $store_ids[$i % count($store_ids)],
                'product_category_id' => $category_ids[$i % count($category_ids)],
                'is_active' => 1,
                'allow_update' => 1,
                'allow_delete' => 1,
                'created_by' => null,
                'last_updated_by' => null,
            ]);
        }

        return $rows;
    }
}
