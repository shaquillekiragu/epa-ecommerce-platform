<?php

use yii\db\Migration;

/**
 * Adds `slug` column to table `{{%product}}`.
 */
class m260501_162200_add_slug_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'slug', 'varchar(255) NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'slug');
    }
}
