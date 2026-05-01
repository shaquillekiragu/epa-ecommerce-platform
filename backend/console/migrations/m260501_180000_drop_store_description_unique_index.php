<?php

use yii\db\Migration;

/**
 * Store descriptions may repeat; only the name stays globally unique for now.
 */
class m260501_180000_drop_store_description_unique_index extends Migration
{
    public function safeUp()
    {
        $this->dropIndex('idx_store_description_unique', '{{%store}}');
    }

    public function safeDown()
    {
        $this->createIndex('idx_store_description_unique', '{{%store}}', 'description', true);
    }
}
