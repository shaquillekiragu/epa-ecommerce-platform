<?php

namespace console\seeders;

use yii\db\Query;
use yii\helpers\Console;

final class BasketSeeder extends BaseSeeder
{
    /**
     * Seeds: basket, basket_product.
     *
     * Requires: users (customers) and products already exist.
     */
    public function seed(int $debug = 1, int $batch_size = 25, int $count = 10): void
    {
        $actor_id = $this->getSuperadminUserId();

        if ($actor_id === null) {
            throw new \RuntimeException('No RBAC assignment found for role "superadmin". Seed/assign a superadmin user first.');
        }

        $customer_ids = (new Query())
            ->select(['id'])
            ->from('{{%user}}')
            ->where(['role' => 'customer'])
            ->orderBy(['id' => SORT_ASC])
            ->column($this->db);

        if (count($customer_ids) === 0) {
            throw new \RuntimeException('No customer users found. Seed users first.');
        }

        $products = (new Query())
            ->select(['id', 'price_in_gbp'])
            ->from('{{%product}}')
            ->orderBy(['id' => SORT_ASC])
            ->all($this->db);

        if (count($products) === 0) {
            throw new \RuntimeException('No products found. Seed catalog first.');
        }

        $tx = $this->db->beginTransaction();

        try {
            $baskets = $this->applyAuditActor($this->buildBaskets($count, $customer_ids), $actor_id);
            $basket_ids = $this->insertData(array_chunk($baskets, $batch_size), 'basket', true);

            $basket_products = $this->applyAuditActor(
                $this->buildBasketProducts($basket_ids, $products),
                $actor_id
            );
            $basket_product_ids = $this->insertData(array_chunk($basket_products, $batch_size), 'basket_product', true);

            // Update price_total now that basket_product rows are known
            $totals_by_basket_id = $this->calculateBasketTotalsInPennies($basket_products, $products);
            foreach ($totals_by_basket_id as $basket_id => $price_total) {
                $this->db->createCommand()
                    ->update('{{%basket}}', ['price_total' => $price_total], ['id' => $basket_id])
                    ->execute();
            }

            $tx->commit();

            if ($debug === 1) {
                Console::output('Seed complete:');
                Console::output('- baskets inserted: ' . count($basket_ids));
                Console::output('- basket_product rows inserted: ' . count($basket_product_ids));
            }
        } catch (\Throwable $e) {
            $tx->rollBack();
            throw $e;
        }
    }

    private function buildBaskets(int $count, array $customer_ids): array
    {
        $rows = [];

        for ($i = 0; $i < $count; $i++) {
            $rows[] = [
                'customer_id' => (int) $customer_ids[$i % count($customer_ids)],
                'price_total' => 0, // updated after basket_product insert
                'allow_update' => 1,
                'allow_delete' => 1,
                'created_by' => null,
                'last_updated_by' => null,
            ];
        }

        return $rows;
    }

    /**
     * @param array $products rows of ['id' => int, 'price_in_gbp' => float]
     */
    private function buildBasketProducts(array $basket_ids, array $products): array
    {
        $rows = [];
        $product_count = count($products);

        foreach ($basket_ids as $i => $basket_id) {
            // each basket gets 1-3 products
            $items = 1 + ($i % 3);

            for ($j = 0; $j < $items; $j++) {
                $product = $products[($i + $j) % $product_count];
                $rows[] = [
                    'basket_id' => (int) $basket_id,
                    'product_id' => (int) $product['id'],
                    'quantity' => 1 + (($i + $j) % 3),
                    'created_by' => null,
                    'last_updated_by' => null,
                ];
            }
        }

        return $rows;
    }

    /**
     * @param array $basket_products rows containing basket_id, product_id, quantity
     * @param array $products rows of ['id' => int, 'price_in_gbp' => float]
     * @return array<int,int> basket_id => price_total (integer pennies)
     */
    private function calculateBasketTotalsInPennies(array $basket_products, array $products): array
    {
        $price_by_product_id = [];
        foreach ($products as $p) {
            $price_by_product_id[(int) $p['id']] = (float) $p['price_in_gbp'];
        }

        $totals = [];
        foreach ($basket_products as $row) {
            $basket_id = (int) $row['basket_id'];
            $product_id = (int) $row['product_id'];
            $qty = (int) $row['quantity'];

            $unit = $price_by_product_id[$product_id] ?? 0.0;
            $line_pennies = (int) round($unit * 100) * $qty;

            if (!isset($totals[$basket_id])) {
                $totals[$basket_id] = 0;
            }
            $totals[$basket_id] += $line_pennies;
        }

        return $totals;
    }
}
