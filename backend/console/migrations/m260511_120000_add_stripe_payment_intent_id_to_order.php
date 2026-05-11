<?php

use yii\db\Migration;

class m260511_120000_add_stripe_payment_intent_id_to_order extends Migration
{
    public function safeUp()
    {
        $table = $this->db->getTableSchema('{{%order}}', true);
        if ($table !== null && !isset($table->columns['stripe_payment_intent_id'])) {
            $this->addColumn('{{%order}}', 'stripe_payment_intent_id', $this->string(255)->null());
        }
    }

    public function safeDown()
    {
        $table = $this->db->getTableSchema('{{%order}}', true);
        if ($table !== null && isset($table->columns['stripe_payment_intent_id'])) {
            $this->dropColumn('{{%order}}', 'stripe_payment_intent_id');
        }
    }
}
