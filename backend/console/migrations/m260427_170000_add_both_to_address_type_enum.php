<?php

use yii\db\Migration;

/**
 * Adds "both" to address.address_type enum.
 */
class m260427_170000_add_both_to_address_type_enum extends Migration
{
    public function safeUp()
    {
        // MySQL enum modification
        $this->alterColumn('{{%address}}', 'address_type', 'enum("shipping", "billing", "both") NOT NULL DEFAULT "both"');
    }

    public function safeDown()
    {
        $this->alterColumn('{{%address}}', 'address_type', 'enum("shipping", "billing") NOT NULL DEFAULT "shipping"');
    }
}

