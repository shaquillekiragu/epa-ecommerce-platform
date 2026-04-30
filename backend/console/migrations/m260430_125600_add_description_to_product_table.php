<?php

use yii\db\Migration;

/**
 * Adds `description` column to table `{{%product}}`.
 */
class m260430_125600_add_description_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'description', 'varchar(255) NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'description');
    }
}
