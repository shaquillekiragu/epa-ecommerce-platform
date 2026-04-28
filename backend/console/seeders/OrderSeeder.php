<?php

namespace console\seeders;

use yii\db\Query;
use yii\helpers\Console;

final class OrderSeeder extends BaseSeeder
{
    /**
     * Seeds: order, order_product.
     *
     * Requires: users (customers), stores, and products already exist.
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

        $store_ids = (new Query())
            ->select(['id'])
            ->from('{{%store}}')
            ->orderBy(['id' => SORT_ASC])
            ->column($this->db);

        if (count($store_ids) === 0) {
            throw new \RuntimeException('No stores found. Seed catalog first.');
        }

        $products = (new Query())
            ->select(['id', 'store_id', 'price_in_gbp'])
            ->from('{{%product}}')
            ->orderBy(['id' => SORT_ASC])
            ->all($this->db);

        if (count($products) === 0) {
            throw new \RuntimeException('No products found. Seed catalog first.');
        }

        $tx = $this->db->beginTransaction();

        try {
            $orders = $this->applyAuditActor(
                $this->buildOrders($count, $customer_ids, $store_ids),
                $actor_id
            );
            $order_ids = $this->insertData(array_chunk($orders, $batch_size), 'order', true);

            $order_products = $this->applyAuditActor(
                $this->buildOrderProducts($order_ids, $orders, $products),
                $actor_id
            );
            $order_product_ids = $this->insertData(array_chunk($order_products, $batch_size), 'order_product', true);

            // Update order.price_total based on order_product lines
            $totals_by_order_id = $this->calculateOrderTotalsInPennies($order_products);
            foreach ($totals_by_order_id as $order_id => $price_total) {
                $this->db->createCommand()
                    ->update('{{%order}}', ['price_total' => $price_total], ['id' => $order_id])
                    ->execute();
            }

            $tx->commit();

            if ($debug === 1) {
                Console::output('Seed complete:');
                Console::output('- orders inserted: ' . count($order_ids));
                Console::output('- order_product rows inserted: ' . count($order_product_ids));
            }
        } catch (\Throwable $e) {
            $tx->rollBack();
            throw $e;
        }
    }

    private function buildOrders(int $count, array $customer_ids, array $store_ids): array
    {
        $statuses = [
            'pending_payment',
            'payment_failed',
            'paid',
            'shipped',
            'delivered',
            'cancelled',
            'refunded',
        ];

        $rows = [];
        $now = time();

        for ($i = 0; $i < $count; $i++) {
            $rows[] = [
                'customer_id' => (int) $customer_ids[$i % count($customer_ids)],
                'store_id' => (int) $store_ids[$i % count($store_ids)],
                'price_total' => 0, // updated after order_product insert
                'order_datetime' => date('Y-m-d H:i:s', $now - ($i * 86400)),
                'status' => $statuses[$i % count($statuses)],
                'allow_update' => 1,
                'allow_delete' => 1,
                'created_by' => null,
                'last_updated_by' => null,
            ];
        }

        return $rows;
    }

    /**
     * Builds order_product lines; selects products and uses current price as purchase price.
     *
     * @param array $orders same order rows used for insert (used for store_id selection)
     * @param array $products rows of ['id' => int, 'store_id' => int, 'price_in_gbp' => float]
     */
    private function buildOrderProducts(array $order_ids, array $orders, array $products): array
    {
        $rows = [];

        foreach ($order_ids as $i => $order_id) {
            $store_id = (int) ($orders[$i]['store_id'] ?? 0);

            // Prefer products from the same store; fall back to any product.
            $store_products = array_values(array_filter($products, static function (array $p) use ($store_id): bool {
                return (int) $p['store_id'] === $store_id;
            }));
            $pool = count($store_products) > 0 ? $store_products : $products;
            $pool_count = count($pool);

            $items_requested = 1 + ($i % 3);
            $items = min($items_requested, $pool_count);

            $used_product_ids = [];
            $cursor = 0;

            while (count($used_product_ids) < $items) {
                $p = $pool[($i + $cursor) % $pool_count];
                $product_id = (int) $p['id'];
                $cursor++;

                if (isset($used_product_ids[$product_id])) {
                    continue;
                }
                $used_product_ids[$product_id] = true;

                $rows[] = [
                    'order_id' => (int) $order_id,
                    'product_id' => $product_id,
                    'price_at_purchase_in_gbp' => (float) $p['price_in_gbp'],
                    'quantity' => 1 + (($i + $cursor) % 3),
                    'created_by' => null,
                    'last_updated_by' => null,
                ];
            }
        }

        return $rows;
    }

    /**
     * @return array<int,int> order_id => price_total (integer pennies)
     */
    private function calculateOrderTotalsInPennies(array $order_products): array
    {
        $totals = [];

        foreach ($order_products as $row) {
            $order_id = (int) $row['order_id'];
            $qty = (int) $row['quantity'];
            $price = (float) $row['price_at_purchase_in_gbp'];

            $line_pennies = (int) round($price * 100) * $qty;

            if (!isset($totals[$order_id])) {
                $totals[$order_id] = 0;
            }
            $totals[$order_id] += $line_pennies;
        }

        return $totals;
    }
}
