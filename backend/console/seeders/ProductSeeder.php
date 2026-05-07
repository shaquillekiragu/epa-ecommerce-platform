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
                // name is unique in this schema; prefix per seed run.
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
            [
                'name' => 'Home & Kitchen',
                'description' => 'Tools and essentials for daily home life.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCcZEI8yj9rt0ybIkNT0SInlRxsF48NCt-ZIMWyZSfS43VFNAqq9_MfZ9tfChxa9i631_REBy-tIwIxG4Gr96og_oNtAoNdZBTiD9P7Wa4bHS4tGAd0CYjawDrb8Jpp0Bf7xdC5_PGxzzeOeC8WgSOJdOavxqJtGAnOZmGjuNSPBvsun1OpRc5O2SrgFzWIxLGTbS39SuwGlni3_FghJxObu8G5_vYozactK4uJtYtUOF5AlBmSCeFiV0IREsSNIyei2W1kFyiiP9WV',
            ],
            [
                'name' => 'Electronics',
                'description' => 'Accessories and handy devices.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCYqVG1bPAuaot8LZjYQTGUGL7oCrcQsxP2RydaWYvyg6YBL0FOqWIKaW5lyIKIeGtJ3ZO1dfiyNFgjtbOyaLbj_deHKdq6sbtyRuQt3-RQWl6BEveEPC7bZyssMLOtHl3NHTYEIeiYKFTUfzrM6QvZfp0SiEKv1jSvcpkHQ0XeJ7rM38Bv5uG4YJU7-JxRJrPjjgKiCuiHO3xYWlBgICpGgsps0H9TJXlN2d-DZl0zmyfjlAXcMQfy0rJ4INk3cdGwD-qJO4tjNYvK',
            ],
            [
                'name' => 'Beauty',
                'description' => 'Personal care and grooming.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAYUS08R0Szh5Jx0wduYqRBT7Ki1k-wqfD9tMcvIlbxUrx7PywOmg5RsgyRGzVFMO5DhkARb1pbPx0tKm1oK9NGdbhSwpvK3tZ0LPlJ4VDloxyyMLavnqHsQbpGxsKJBohTF_wmQ9NQovfAxoeqaimXa2bKKaAFSXFseiFhsgnEoBfdb4GVVpS6UpPptgIYpYqN5PKoRZY8K9g_UyNC_aa1z2k-Do7T_Ux9qzmTAjQvISS9xoX4JuH_hhqdlveQPYgAjbh1lpl8E5Nm',
            ],
            [
                'name' => 'Sports',
                'description' => 'Fitness and outdoor gear.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAlxnrWt_gMa7UF15hTXAen0wNOxGpFHbQ5fNZwF37f4in-0UQ5NnUoLKa7NJFAmzSYarAUK7G8Omq5nLGKCtkX5bMIT0ehkncGhL_LqeHk3aaNtziNFsGVpagutbkLCIJYne409JH7HUMEZlD0PJ7g9YCB0IvfFh2itfCdUUc6B__4UuQr8Jsh7xF3relYOmDznwYvcoHMGb_xRhazEO_iEJU60QhbJPwfpMEikqWoorYAzVinvpCpw4_glRR_fzCIQByP8GUVdXhB',
            ],
            [
                'name' => 'Books',
                'description' => 'Reading and stationery.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBzXGnXhpG9OzkZmpZz-B73aGTXl1iNy1fKSLWuKaqWRCRvbPtzKORyRSNQf9ayl93z_wosLPt1qg7kXzTsSCgDXINK8mZLbXfe8IccIRbkRe_tX5NPEQA-_8f-F0NOVFrqUi3QLG2j5A1vtPtkwW_fJa5u1nt95zkI8ha-hHMnF7vfPzuez2bh9aKytMTqwJDXYAMcsVW_IqRm-MfMTFnk1rtfFGxNOVJRqg-i-SfQ_-wl952-4-p5qRbncJf6vVtVH3-KmQOvhNa5',
            ],
            [
                'name' => 'Toys',
                'description' => 'Games and fun for all ages.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA50OmyAKcg-1jOCo-NetkshDh_mmriA1RsStiBj1IJALJI86RY3Vm142_0LQByng0lGPfuho7GAMvfFLKfHTr5u-fFyz0swvy_4iDyMkNEjCAEytHD5gzWc4lXgVrWcNirVuPggYxfs7YVSawNtCXJtiUnURQnzJIxoj2b7EjiJLhCHpcKJZ4IayKSg-uol6vFeyYxi3zJWhIvuyI0WI5YumNtEM6xZ_vYBV5NeKzlSXOvfZq8n_Sj0IsYXoWv_lSu0UBn5D2sz3Tf',
            ],
            [
                'name' => 'Grocery',
                'description' => 'Pantry items and snacks.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDAzUpBqQ-Bh3LcO7H9qydum8LaCWKG_VRcixf0RQmtfJJx6VFVtjtAoJsCVxsaub81rPxkEslhLIfrw7UTUPpr6-ztepNya5N5yAlPr2t4JMm7UMgW7V6Jhjh0enzrolb2YIkjt0gNAQnFwWf-451fiwIlZnLdySnp99FhtKuBlqhWT2_FCkGALUDCo_6Xv8udrnbdk9OrqkaSr_fp9emVDIJqLmm6sZ8GT7HU4kBkcjizWoiPJdQUVspgFvdU8qHDDtg-EpdNdVQC',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Everyday wear and accessories.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCPg5T2Q__xF4ZKGG7YG6x-vd1f27QP0r6gX54rsYW5T-rta_0X9K9zP6TeoibTptJmx31PkOdMK_7kA7sNFaXA_l5XP9t68VdVvVAjr2ubD9uW1-IFcr11H1MaP7xqW_Ad1e8hakxuakwRo2oduQbubIgFZ2LR4csfbYHlE6bc6L8QaooZ9w9nzVbBVoObD3beUyjVmht0KsbXc6dRf68ScZCPiKM-sdwfCKAJVT6Zx1L6O54FrLiTW20KVLk35eTnwrM7UrCldDUQ',
            ],
            [
                'name' => 'Garden',
                'description' => 'Plants and garden supplies.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBanppMpZkWX00vOfTnPdov10Llx78bqqHkOuzZSrSLX-2pwl-W-_kT2xL88fkEy6G6Xl6kdTCqpH0YZjAuMNGWeiVFHEqu9VmiNV6WGGz6QxcPVl4C5wMhmE17e6cHkJkT3gwCYZ5F2FqgKZfTwWIt4N6FU0mlIsPoMp-OLtAdzuQqPZdjAMoC8sVX4a1xMvWRCsm5u3HSe8yHFecqYCUhNcHNJ86RbjrnJoh2iXQJXhKDbO6QTTJktKwUHYvg95VEDreJxKbgwHUN',
            ],
            [
                'name' => 'Office',
                'description' => 'Workspace essentials.',
                'thumbnail' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBTefx-Zr7C3Zz09rxeBvmAXBZicGaXOe12Q22BL8OySXqwHFQsktmta50p3IZaQrHDzSZSrNfXJVygilydEZb_uHpKGWSYCqugICYGGaFaX2GQV_v-HY3DIax-dVRdWJqToCtDcg-_fYu2HyJzdIS_Q035sRN-tpS0ComlgmeVGVSpHK1BnqtGDtGAumyZyGo07KkRR-jXUnbZZWDQHcSVPZs1skgJeip5XsM3a8kfQd6A0PXozoNFp6xer71uGYZ9RsNKHiUMVi84',
            ],
        ];

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $rows[$i] = array_merge($row, [
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
