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
        $actor_id = $this->ensureSuperadminUserId();

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
            Console::output('Seeding stores...');
            $stores_done = 0;
            $stores_total = count($stores);
            Console::startProgress(0, $stores_total);
            $store_ids = $this->insertDataWithCallback(
                array_chunk($stores, $batch_size),
                'store',
                true,
                static function () use (&$stores_done, $stores_total): void {
                    $stores_done++;
                    Console::updateProgress($stores_done, $stores_total);
                }
            );
            Console::endProgress();

            Console::output('Seeding product categories...');
            $categories_done = 0;
            $categories_total = count($categories);
            Console::startProgress(0, $categories_total);
            $category_ids = $this->insertDataWithCallback(
                array_chunk($categories, $batch_size),
                'product_category',
                true,
                static function () use (&$categories_done, $categories_total): void {
                    $categories_done++;
                    Console::updateProgress($categories_done, $categories_total);
                }
            );
            Console::endProgress();

            $products = $this->applyAuditActor(
                $this->buildProducts($count, $store_ids, $category_ids, $this->seed_run_prefix),
                $actor_id
            );
            Console::output('Seeding products...');
            $products_done = 0;
            $products_total = count($products);
            Console::startProgress(0, $products_total);
            $product_ids = $this->insertDataWithCallback(
                array_chunk($products, $batch_size),
                'product',
                true,
                static function () use (&$products_done, $products_total): void {
                    $products_done++;
                    Console::updateProgress($products_done, $products_total);
                }
            );
            Console::endProgress();

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
            ['name' => 'Northstar Goods', 'description' => 'Everyday essentials, done well.'],
            ['name' => 'Saffron & Steel', 'description' => 'Bold flavors and durable tools.'],
            ['name' => 'Harbor & Hearth', 'description' => 'Home comforts and coastal classics.'],
            ['name' => 'Cedarline Market', 'description' => 'Natural picks for modern living.'],
            ['name' => 'Metro Corner', 'description' => 'Fast-moving urban staples.'],
            ['name' => 'Sunrise Traders', 'description' => 'Seasonal favorites and daily deals.'],
            ['name' => 'Paper & Pixel', 'description' => 'Stationery and small tech accessories.'],
            ['name' => 'Verdant Supply', 'description' => 'Plants, pots, and green living.'],
            ['name' => 'Atlas Outlet', 'description' => 'Travel gear and practical carry.'],
            ['name' => 'Oak & Olive', 'description' => 'Kitchen basics with a premium feel.'],
        ];

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $merchant_id = $merchant_ids[$i % count($merchant_ids)];
            $rows[$i] = array_merge($row, [
                // name and description are unique in this schema; prefix per seed run.
                'name' => $prefix . $row['name'],
                'description' => $prefix . $row['description'],
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
            ['name' => 'Home & Kitchen', 'description' => 'Tools and essentials for daily home life.', 'thumbnail' => null],
            ['name' => 'Electronics', 'description' => 'Accessories and handy devices.', 'thumbnail' => null],
            ['name' => 'Beauty', 'description' => 'Personal care and grooming.', 'thumbnail' => null],
            ['name' => 'Sports', 'description' => 'Fitness and outdoor gear.', 'thumbnail' => null],
            ['name' => 'Books', 'description' => 'Reading and stationery.', 'thumbnail' => null],
            ['name' => 'Toys', 'description' => 'Games and fun for all ages.', 'thumbnail' => null],
            ['name' => 'Grocery', 'description' => 'Pantry items and snacks.', 'thumbnail' => null],
            ['name' => 'Fashion', 'description' => 'Everyday wear and accessories.', 'thumbnail' => null],
            ['name' => 'Garden', 'description' => 'Plants and garden supplies.', 'thumbnail' => null],
            ['name' => 'Office', 'description' => 'Workspace essentials.', 'thumbnail' => null],
        ];

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $rows[$i] = array_merge($row, [
                // name is unique in this schema; prefix per seed run.
                'name' => $prefix . $row['name'],
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
            ['name' => 'Stainless Water Bottle', 'price_in_gbp' => 14.99, 'number_in_stock' => 120, 'sku_code' => 'SKU-WB-0001', 'weight_in_grams' => 320, 'thumbnail' => 'water-bottle.jpg'],
            ['name' => 'Ceramic Coffee Mug', 'price_in_gbp' => 9.50, 'number_in_stock' => 200, 'sku_code' => 'SKU-MUG-0002', 'weight_in_grams' => 410, 'thumbnail' => 'coffee-mug.jpg'],
            ['name' => 'USB-C Cable 2m', 'price_in_gbp' => 7.99, 'number_in_stock' => 500, 'sku_code' => 'SKU-USBC-0003', 'weight_in_grams' => 80, 'thumbnail' => 'usb-c-cable.jpg'],
            ['name' => 'Notebook A5 (Dotted)', 'price_in_gbp' => 6.49, 'number_in_stock' => 350, 'sku_code' => 'SKU-NB-0004', 'weight_in_grams' => 250, 'thumbnail' => 'notebook.jpg'],
            ['name' => 'Wireless Mouse', 'price_in_gbp' => 19.95, 'number_in_stock' => 160, 'sku_code' => 'SKU-MSE-0005', 'weight_in_grams' => 110, 'thumbnail' => 'mouse.jpg'],
            ['name' => 'Kitchen Knife Set', 'price_in_gbp' => 39.00, 'number_in_stock' => 80, 'sku_code' => 'SKU-KNF-0006', 'weight_in_grams' => 900, 'thumbnail' => 'knife-set.jpg'],
            ['name' => 'Resistance Bands', 'price_in_gbp' => 11.25, 'number_in_stock' => 240, 'sku_code' => 'SKU-RB-0007', 'weight_in_grams' => 180, 'thumbnail' => 'bands.jpg'],
            ['name' => 'LED Desk Lamp', 'price_in_gbp' => 24.75, 'number_in_stock' => 95, 'sku_code' => 'SKU-LMP-0008', 'weight_in_grams' => 650, 'thumbnail' => 'desk-lamp.jpg'],
            ['name' => 'Organic Snack Pack', 'price_in_gbp' => 12.00, 'number_in_stock' => 300, 'sku_code' => 'SKU-SNK-0009', 'weight_in_grams' => 450, 'thumbnail' => 'snack-pack.jpg'],
            ['name' => 'Mini Tool Kit', 'price_in_gbp' => 17.80, 'number_in_stock' => 140, 'sku_code' => 'SKU-TK-0010', 'weight_in_grams' => 520, 'thumbnail' => 'tool-kit.jpg'],
        ];

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $rows[$i] = array_merge($row, [
                // name is unique, and sku_code has a unique index; prefix per seed run.
                'name' => $prefix . $row['name'],
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
