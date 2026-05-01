<?php

use yii\db\Migration;

/**
 * Adds `seo_title` column to table `{{%product}}`.
 */
class m260501_162600_add_seo_title_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'seo_title', 'varchar(255) NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'seo_title');
    }
}
