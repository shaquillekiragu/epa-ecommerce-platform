<?php

namespace console\seeders;

use common\models\Product;
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
        $categories = $this->applyAuditActor($this->buildCategories($count), $actor_id);

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
                $this->buildProducts($count, $store_ids, $category_ids),
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

    /**
     * Inserts products using only store and product_category rows already in the database.
     * Does not create stores or categories.
     */
    public function seedExtraProductsUsingExistingCatalog(int $debug = 1, int $count = 30): void
    {
        if ($count <= 0) {
            throw new \InvalidArgumentException('count must be positive.');
        }

        $store_ids = (new Query())
            ->select(['id'])
            ->from('{{%store}}')
            ->orderBy(['id' => SORT_ASC])
            ->column($this->db);

        $category_ids = (new Query())
            ->select(['id'])
            ->from('{{%product_category}}')
            ->orderBy(['id' => SORT_ASC])
            ->column($this->db);

        if (count($store_ids) === 0) {
            throw new \RuntimeException('No stores in the database. Seed stores first.');
        }

        if (count($category_ids) === 0) {
            throw new \RuntimeException('No product categories in the database. Seed categories first.');
        }

        $actor_id = $this->ensureSuperadminUserId();

        $thumbnail_pool = [
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCsP0brIpa6RGliR_LnX4sKRoU5eofeW1Zk-j5zSAUHJHWywKONN3xutvNBjQpCbpTzsdzDjaodtQdAobDg5IdvQHpgtfq3FaqvjCSCFj3Qmj4MD2IWh16tSuPlEesIixtZ25WnDiKO_itfhOglNTyzQluQspQP4th8BOtniEuiiwHRvCBCnyaD58107jfhA16-4ZfqVBw65LPFjiXh8ym2fz-UqwxHxyjnIO9_cCZgZlMGXadqHIXuXb6bSgGfuCHtzqQsA3W0B0EL',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuAfAjzhD8IU1hWkHsvqBsDKhVYKRzeaPsQZw6Ksx4OK20eyklJ2SgIB2hQBUsikftc4iAck2LsyhcdhRwHT1iw_MYG8sb3afvCeIRfYx7I3LkZ-zQ5lEPo8q39XdWeBVDZK8d5JOzIeHUFCvvP8Txcpva7_HLVh4Yv8Hc8VixszV-zV6MjI3x3FcYhBKichpNVsYrHcsoyp3lvhFtD2-hTMTwNCZSQo8-zwFpxRwq2Z0C5d24UzjTLP9wPYXdk37OKiPP5FdogM37yj',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuC2Jql8K5UdayOQMiRYTUtVqzjTtl1kTUG4DHWLWEmePyWLIu15We9UGWolWc97oLi80pi6TkEEf4Z3uSN--d6bvNVogVfDNzjpQLd_GMaXh23pu98CKy7q3itlpdeItGbCwl6lh9OHtrl8o8NKyzhliECJSklJ-336EW4AxVeIDfzhKbfd3dw8ZIBrBl3p-5wLXZjoo5KsNIg4kbtOFxYteJOxrOirLTSWF6xUsRl6CgpyZ1pGTIR17WXKF9sAxlRKEWH0exKyfEL1',
        ];

        $inserted = 0;

        $tx = $this->db->beginTransaction();

        try {
            for ($i = 0; $i < $count; $i++) {
                $n = $i + 1;
                $store_id = (int) $store_ids[$i % count($store_ids)];
                $category_id = (int) $category_ids[$i % count($category_ids)];

                $sku_base = $this->seed_run_prefix . 'X-' . str_pad((string) $n, 4, '0', STR_PAD_LEFT);
                if (strlen($sku_base) > 64) {
                    $sku_base = substr($sku_base, 0, 64);
                }

                $product = new Product();
                $product->store_id = $store_id;
                $product->product_category_id = $category_id;
                $product->name = 'Catalog Extra Item ' . $n;
                $product->sku_code = $sku_base;
                $product->price_in_gbp = round(4.99 + ($i % 47) * 0.75 + ($i % 3) * 2.5, 2);
                $product->number_in_stock = 20 + ($i * 7) % 180;
                $product->weight_in_grams = 50 + ($i * 13) % 2000;
                $product->thumbnail = $thumbnail_pool[$i % count($thumbnail_pool)];
                $product->is_active = true;
                $product->allow_update = true;
                $product->allow_delete = true;
                $product->created_by = $actor_id;
                $product->last_updated_by = $actor_id;

                if (!$product->save()) {
                    throw new \RuntimeException('Failed to save product: ' . json_encode($product->errors));
                }

                $inserted++;
            }

            $tx->commit();
        } catch (\Throwable $e) {
            $tx->rollBack();
            throw $e;
        }

        if ($debug === 1) {
            Console::output('Inserted ' . $inserted . ' products using existing stores and categories.');
        }
    }

    /**
     * Deletes every row in `product` (after clearing `order_product` and `basket_product`), then inserts
     * the same canonical catalog products as {@see self::buildProducts()} using existing stores and categories.
     *
     * @throws \RuntimeException when no stores, categories, or superadmin actor exists
     */
    public function replaceAllProductsWithSeedCatalog(int $debug = 1, int $count = 40): void
    {
        if ($count <= 0) {
            throw new \InvalidArgumentException('count must be positive.');
        }

        $store_ids = (new Query())
            ->select(['id'])
            ->from('{{%store}}')
            ->orderBy(['id' => SORT_ASC])
            ->column($this->db);

        $category_ids = (new Query())
            ->select(['id'])
            ->from('{{%product_category}}')
            ->orderBy(['id' => SORT_ASC])
            ->column($this->db);

        if (count($store_ids) === 0) {
            throw new \RuntimeException('No stores in the database. Seed catalog (stores + categories) first.');
        }

        if (count($category_ids) === 0) {
            throw new \RuntimeException('No product categories in the database. Seed categories first.');
        }

        $actor_id = $this->ensureSuperadminUserId();

        $tx = $this->db->beginTransaction();

        try {
            $this->db->createCommand()->delete('{{%order_product}}')->execute();
            $this->db->createCommand()->delete('{{%basket_product}}')->execute();
            $this->db->createCommand()->delete('{{%product}}')->execute();

            $rows = $this->applyAuditActor(
                $this->buildProducts($count, $store_ids, $category_ids),
                $actor_id
            );

            $inserted = 0;
            $total = count($rows);
            if ($debug === 1) {
                Console::output('Inserting ' . $total . ' seed products...');
                Console::startProgress(0, $total);
            }

            foreach ($rows as $row) {
                $product = new Product();
                $product->setAttributes($row, false);
                if (!$product->save()) {
                    throw new \RuntimeException('Failed to save product: ' . json_encode($product->errors));
                }
                $inserted++;
                if ($debug === 1) {
                    Console::updateProgress($inserted, $total);
                }
            }

            if ($debug === 1) {
                Console::endProgress();
            }

            $tx->commit();
        } catch (\Throwable $e) {
            $tx->rollBack();
            throw $e;
        }

        if ($debug === 1) {
            Console::output('Replaced catalog with ' . $inserted . ' seed products.');
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

    private function buildCategories(int $count): array
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
                'name' => $row['name'],
                'allow_update' => 1,
                'allow_delete' => 1,
                'created_by' => null,
                'last_updated_by' => null,
            ]);
        }

        return $rows;
    }

    /**
     * Thumbnail URLs reused across catalog seed products (cycles for extended rows).
     *
     * @return list<string>
     */
    private static function catalogSeederThumbnailPool(): array
    {
        return [
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCsP0brIpa6RGliR_LnX4sKRoU5eofeW1Zk-j5zSAUHJHWywKONN3xutvNBjQpCbpTzsdzDjaodtQdAobDg5IdvQHpgtfq3FaqvjCSCFj3Qmj4MD2IWh16tSuPlEesIixtZ25WnDiKO_itfhOglNTyzQluQspQP4th8BOtniEuiiwHRvCBCnyaD58107jfhA16-4ZfqVBw65LPFjiXh8ym2fz-UqwxHxyjnIO9_cCZgZlMGXadqHIXuXb6bSgGfuCHtzqQsA3W0B0EL',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuAfAjzhD8IU1hWkHsvqBsDKhVYKRzeaPsQZw6Ksx4OK20eyklJ2SgIB2hQBUsikftc4iAck2LsyhcdhRwHT1iw_MYG8sb3afvCeIRfYx7I3LkZ-zQ5lEPo8q39XdWeBVDZK8d5JOzIeHUFCvvP8Txcpva7_HLVh4Yv8Hc8VixszV-zV6MjI3x3FcYhBKichpNVsYrHcsoyp3lvhFtD2-hTMTwNCZSQo8-zwFpxRwq2Z0C5d24UzjTLP9wPYXdk37OKiPP5FdogM37yj',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuC2Jql8K5UdayOQMiRYTUtVqzjTtl1kTUG4DHWLWEmePyWLIu15We9UGWolWc97oLi80pi6TkEEf4Z3uSN--d6bvNVogVfDNzjpQLd_GMaXh23pu98CKy7q3itlpdeItGbCwl6lh9OHtrl8o8NKyzhliECJSklJ-336EW4AxVeIDfzhKbfd3dw8ZIBrBl3p-5wLXZjoo5KsNIg4kbtOFxYteJOxrOirLTSWF6xUsRl6CgpyZ1pGTIR17WXKF9sAxlRKEWH0exKyfEL1',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuDqds0N5VSs_xqnweqTXweffd1SP4Ou_G0Ms46keqhH9JUd6ze4Ty7sgUJqhgQnzStyX6FhEFTn8uTJMYJ2tJ9GlDzQB5qsHYfloeMcpLq9B4yQ67KasblOOHwnoREEdOrK-bf2W3RDxbjfAGgBk_IU5JdThQ6os2c26OLr_f91CTxg2lRhMJqZ1p6Ljxcfkh_DFHR1HBT5BOYIrSLMPd8J50Rc5nCEVbgh4dshjraDcV8d-a3cYE-BDlZDT3d6wNDL1svgJ7qErbHf',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuD3mmh9SuMl1xwD_2o2o-EkxHu8QFn75ViLccU-0EgWew5gEvbOtH5ZcErmU_sN9SkMhKB0Ytb4S0O5PQY-GUFKRzdllvWUj9b8BOWZPHbq19H0_dePI46SLiv21IS0utkvinCeCuxxkQQYinjr4lqIVH5tEo6Sls3E7Dtm9fiNzXuM2rDwlj2vC4gitJaX1h83hFiXVL6CA7dd8DUjJHhwwKNizo80iQoUW6SP1QebFORaUj14GjMdqsfhBezv8BIkR5AuCEqMg-Nd',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCZLj9bNLJUvpnZnLY6Bgiq86rRGjK2VVcSLZClJOge_S2Tv5zAzuLmRDTpKQShlBcVLq36KuSPdFBATFtnxSk-PjSJ0leE6Owci32IethpNSvKmsNr8NPz8IDGWLk0G-oZyHeRSez5nwhrCs9EahKl7rahi6QvJIJaD9lz2wVuU70P3yO04cfz3B1CrwCqc5XXYztfBlYHRlIFQ5UJnkLbIZEiJQdQGrzFuXRGFX3dS_RZAf_bYUcghps7XFODtiEy7irhvzTRXkmH',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCQ7vYmK39cpanEbP9F_pl6TIhEBm-aND7rHyKQq24df7sbqColT6VBVsEgNYOiVINfMgUX0ZFkaIoNm5PBMXdd_tP0BrMBdiakyJ6nBf-hyiE4bzAWM6NhA4cKS41tqCxsvMtru2Fy2iRgkmsa2wxz7XNpsyNNfvD5nI6unJ0pCgcLZCc8ambrAyCvaQh7dexb5tftSo3UM7jQvdvGTKY6ZVHod1I8h8ehbwfLFZ07852Vk9DdmaZhKQmSKtfRKoLBqsgDO1wbHy2O',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuAcVgGwt4aWVGaYQcJJepzaJ-xNl3z7E6G48286Yz3etaO7q_2bhtkrtSkbWFQ-J5AQLVi-KDhJ7d2hzLB4wQUG5NQuVZlWgHIu1ZPSJnDGNz7Yk9i6-8wlNatBlHXRDzy7Rz94CbjQruG4Flit_la3LW6b8i5TiD_9Pklel5jhiYF1kY4MJPOUFXeInvQrqo0jy_NPRcW1vnc3KYk4KVoE414zySa7ADjiEgmDKL_lNCwBW9NZOJJrRFsvt6ML_F3lFCzKNaPVGhog',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuDw5N8KG4aAtFEMnURXEZhMB3XWiqMw_z5ICFuVotuv96IB7TxXPBvM5dowp2pBjaTReP1ukinnsU_fuvIR4SEXXzDc7WdKxZwGIwDRFUKQ49Mpax0n8-uaPr-XKQf4Qp-_Un15P15ngh5RkYjo54ZlqVrqhZZvjsxzVRO1lQQhScsBWw4vYe8DYEvPM3ZbL_I-sM6pJAttH-fYPSc1UQ5hij-tJNykYukGDnKZLfsV2ogyYvrn51ODfmcpn2t5oGhlR34e12NRmzTw',
            'https://lh3.googleusercontent.com/aida-public/AB6AXuAapD6o2qZSRK-NbGnk5uT9cBMw6prkPlo3wtEd6dBj6EDIsfL1OWUoCZ46XrUiGE9cyUoqp48GP8Mi05APwvMW3wBHrAX6r0ACbOE3vxvGbG7qQE6OseMDqGjeZITGRhm5dUtc03YI4rmtghSUXnDeh2x_eZ_6V8_dU98Tm3wlmYPmd-A7-F2HFjGHHm8RPHPirdjMxKEzCJYakpDjdi_5Rl66npqva6c93VZdr888LPk7D-2u0H51k1sM53m40udymHej2_brn5QZ',
        ];
    }

    /**
     * Additional fixed catalog rows (SKUs SKU-EX-0011 … assigned in buildProducts).
     *
     * @return list<array{0: string, 1: float, 2: int, 3: int}>
     */
    private static function extendedCatalogProductTuples(): array
    {
        return [
            ['Bamboo Cutting Board', 18.99, 85, 1200],
            ['Cast Iron Skillet 10 inch', 34.99, 60, 2800],
            ['Microfibre Cleaning Cloths 5 Pack', 8.49, 400, 220],
            ['Portable Bluetooth Speaker', 49.99, 55, 560],
            ['Mechanical Keyboard', 79.99, 45, 980],
            ['Webcam HD 1080p', 42.00, 70, 340],
            ['Yoga Mat', 21.50, 150, 1100],
            ['Foam Roller', 16.75, 130, 600],
            ['Stainless Steel Straws 8 Pack', 6.99, 600, 90],
            ['Travel Pillow Memory Foam', 19.99, 110, 450],
            ['Insulated Lunch Bag', 15.49, 175, 380],
            ['Silicone Baking Mat', 12.99, 220, 210],
            ['Digital Kitchen Scale', 24.00, 100, 420],
            ['Herb Scissors Five Blade', 9.99, 300, 85],
            ['Reusable Beeswax Food Wrap', 13.25, 190, 160],
            ['Desk Cable Organizer', 11.50, 280, 95],
            ['Monitor Stand Riser', 32.00, 88, 1800],
            ['Ergonomic Wrist Rest', 14.25, 200, 155],
            ['Laptop Sleeve 13 to 14 inch', 26.99, 140, 280],
            ['HDMI Cable 1.8m', 12.49, 320, 140],
            ['Power Strip Four Socket', 18.00, 160, 520],
            ['AA Rechargeable Batteries 4 Pack', 11.99, 450, 120],
            ['Compact First Aid Kit', 16.50, 95, 480],
            ['Water Filter Pitcher', 27.75, 72, 890],
            ['Vacuum Storage Bags 6 Pack', 14.00, 210, 640],
            ['Lint Roller Refills 3 Pack', 7.25, 380, 190],
            ['Over Door Hooks Stainless', 10.99, 265, 310],
            ['Plant Mister Spray Bottle', 8.00, 340, 180],
            ['Ceramic Coaster Set 4 Pack', 13.50, 185, 420],
            ['Cotton Tote Bag', 5.99, 500, 120],
        ];
    }

    private function buildProducts(int $count, array $store_ids, array $category_ids): array
    {
        $thumbs = self::catalogSeederThumbnailPool();

        $rows = [
            ['name' => 'Stainless Water Bottle', 'price_in_gbp' => 14.99, 'number_in_stock' => 120, 'sku_code' => 'SKU-WB-0001', 'weight_in_grams' => 320, 'thumbnail' => $thumbs[0]],
            ['name' => 'Ceramic Coffee Mug', 'price_in_gbp' => 9.50, 'number_in_stock' => 200, 'sku_code' => 'SKU-MUG-0002', 'weight_in_grams' => 410, 'thumbnail' => $thumbs[1]],
            ['name' => 'USB-C Cable 2m', 'price_in_gbp' => 7.99, 'number_in_stock' => 500, 'sku_code' => 'SKU-USBC-0003', 'weight_in_grams' => 80, 'thumbnail' => $thumbs[2]],
            ['name' => 'Notebook A5 (Dotted)', 'price_in_gbp' => 6.49, 'number_in_stock' => 350, 'sku_code' => 'SKU-NB-0004', 'weight_in_grams' => 250, 'thumbnail' => $thumbs[3]],
            ['name' => 'Wireless Mouse', 'price_in_gbp' => 19.95, 'number_in_stock' => 160, 'sku_code' => 'SKU-MSE-0005', 'weight_in_grams' => 110, 'thumbnail' => $thumbs[4]],
            ['name' => 'Kitchen Knife Set', 'price_in_gbp' => 39.00, 'number_in_stock' => 80, 'sku_code' => 'SKU-KNF-0006', 'weight_in_grams' => 900, 'thumbnail' => $thumbs[5]],
            ['name' => 'Resistance Bands', 'price_in_gbp' => 11.25, 'number_in_stock' => 240, 'sku_code' => 'SKU-RB-0007', 'weight_in_grams' => 180, 'thumbnail' => $thumbs[6]],
            ['name' => 'LED Desk Lamp', 'price_in_gbp' => 24.75, 'number_in_stock' => 95, 'sku_code' => 'SKU-LMP-0008', 'weight_in_grams' => 650, 'thumbnail' => $thumbs[7]],
            ['name' => 'Organic Snack Pack', 'price_in_gbp' => 12.00, 'number_in_stock' => 300, 'sku_code' => 'SKU-SNK-0009', 'weight_in_grams' => 450, 'thumbnail' => $thumbs[8]],
            ['name' => 'Mini Tool Kit', 'price_in_gbp' => 17.80, 'number_in_stock' => 140, 'sku_code' => 'SKU-TK-0010', 'weight_in_grams' => 520, 'thumbnail' => $thumbs[9]],
        ];

        $poolLen = count($thumbs);
        foreach (self::extendedCatalogProductTuples() as $i => $tuple) {
            $n = 11 + $i;
            $rows[] = [
                'name' => $tuple[0],
                'price_in_gbp' => $tuple[1],
                'number_in_stock' => $tuple[2],
                'sku_code' => 'SKU-EX-' . str_pad((string) $n, 4, '0', STR_PAD_LEFT),
                'weight_in_grams' => $tuple[3],
                'thumbnail' => $thumbs[$i % $poolLen],
            ];
        }

        $rows = array_slice($rows, 0, $count);

        foreach ($rows as $i => $row) {
            $rows[$i] = array_merge($row, [
                'name' => $row['name'],
                'sku_code' => $this->seed_run_prefix . $row['sku_code'],
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
