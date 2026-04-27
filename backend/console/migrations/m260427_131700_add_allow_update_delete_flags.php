<?php

use yii\db\Migration;

/**
 * Adds allow_update and allow_delete flags to platform tables.
 */
class m260427_131700_add_allow_update_delete_flags extends Migration
{
    public function safeUp()
    {
        $tables = [
            '{{%user}}',
            '{{%address}}',
            '{{%store}}',
            '{{%product_category}}',
            '{{%product}}',
            '{{%basket}}',
            '{{%basket_product}}',
            '{{%order}}',
            '{{%order_product}}',
            '{{%user_address}}',
        ];

        foreach ($tables as $table) {
            $this->addColumn($table, 'allow_update', $this->boolean()->notNull()->defaultValue(true));
            $this->addColumn($table, 'allow_delete', $this->boolean()->notNull()->defaultValue(true));
        }
    }

    public function safeDown()
    {
        $tables = [
            '{{%user_address}}',
            '{{%order_product}}',
            '{{%order}}',
            '{{%basket_product}}',
            '{{%basket}}',
            '{{%product}}',
            '{{%product_category}}',
            '{{%store}}',
            '{{%address}}',
            '{{%user}}',
        ];

        foreach ($tables as $table) {
            $this->dropColumn($table, 'allow_delete');
            $this->dropColumn($table, 'allow_update');
        }
    }
}
