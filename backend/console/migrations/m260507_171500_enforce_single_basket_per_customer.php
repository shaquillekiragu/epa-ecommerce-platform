<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Enforces at most one basket row per customer.
 *
 * If duplicates exist, merges basket_product lines into the newest basket (max id)
 * and deletes the older duplicate baskets before adding the unique index.
 */
class m260507_171500_enforce_single_basket_per_customer extends Migration
{
    public function safeUp()
    {
        $duplicateCustomerIds = (new Query())
            ->select(['customer_id'])
            ->from('{{%basket}}')
            ->groupBy(['customer_id'])
            ->having('COUNT(*) > 1')
            ->column($this->db);

        foreach ($duplicateCustomerIds as $customerId) {
            $basketIds = (new Query())
                ->select(['id'])
                ->from('{{%basket}}')
                ->where(['customer_id' => (int) $customerId])
                ->orderBy(['id' => SORT_DESC])
                ->column($this->db);

            if (count($basketIds) < 2) {
                continue;
            }

            $keepBasketId = (int) array_shift($basketIds);
            $dropBasketIds = array_map('intval', $basketIds);

            foreach ($dropBasketIds as $dropBasketId) {
                $rows = (new Query())
                    ->select(['id', 'product_id', 'quantity'])
                    ->from('{{%basket_product}}')
                    ->where(['basket_id' => $dropBasketId])
                    ->all($this->db);

                foreach ($rows as $row) {
                    $productId = (int) $row['product_id'];
                    $qty = (int) $row['quantity'];

                    $existing = (new Query())
                        ->select(['id', 'quantity'])
                        ->from('{{%basket_product}}')
                        ->where(['basket_id' => $keepBasketId, 'product_id' => $productId])
                        ->one($this->db);

                    if ($existing) {
                        $this->update(
                            '{{%basket_product}}',
                            ['quantity' => ((int) $existing['quantity']) + $qty],
                            ['id' => (int) $existing['id']]
                        );
                        $this->delete('{{%basket_product}}', ['id' => (int) $row['id']]);
                    } else {
                        $this->update(
                            '{{%basket_product}}',
                            ['basket_id' => $keepBasketId],
                            ['id' => (int) $row['id']]
                        );
                    }
                }
            }

            $this->delete('{{%basket}}', ['id' => $dropBasketIds]);
        }

        $this->createIndex('idx_basket_unique_customer_id', '{{%basket}}', ['customer_id'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('idx_basket_unique_customer_id', '{{%basket}}');
    }
}
