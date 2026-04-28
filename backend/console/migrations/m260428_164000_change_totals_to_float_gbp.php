<?php

use yii\db\Migration;

/**
 * Switches basket.price_total and order.price_total from int (pence) to float (GBP).
 *
 * Existing data is converted from pence -> pounds by dividing by 100.
 */
class m260428_164000_change_totals_to_float_gbp extends Migration
{
    public function safeUp()
    {
        $basket_schema = $this->db->schema->getTableSchema('{{%basket}}', true);
        if ($basket_schema !== null && isset($basket_schema->columns['price_total'])) {
            $this->alterColumn('{{%basket}}', 'price_total', 'float NOT NULL');
            // convert existing pence -> pounds
            $this->execute('UPDATE {{%basket}} SET price_total = price_total / 100');
        }

        $order_schema = $this->db->schema->getTableSchema('{{%order}}', true);
        if ($order_schema !== null && isset($order_schema->columns['price_total'])) {
            $this->alterColumn('{{%order}}', 'price_total', 'float NOT NULL');
            // convert existing pence -> pounds
            $this->execute('UPDATE {{%order}} SET price_total = price_total / 100');
        }
    }

    public function safeDown()
    {
        $order_schema = $this->db->schema->getTableSchema('{{%order}}', true);
        if ($order_schema !== null && isset($order_schema->columns['price_total'])) {
            // convert existing pounds -> pence
            $this->execute('UPDATE {{%order}} SET price_total = ROUND(price_total * 100)');
            $this->alterColumn('{{%order}}', 'price_total', 'int NOT NULL');
        }

        $basket_schema = $this->db->schema->getTableSchema('{{%basket}}', true);
        if ($basket_schema !== null && isset($basket_schema->columns['price_total'])) {
            // convert existing pounds -> pence
            $this->execute('UPDATE {{%basket}} SET price_total = ROUND(price_total * 100)');
            $this->alterColumn('{{%basket}}', 'price_total', 'int NOT NULL');
        }
    }
}

