<?php

use yii\db\Migration;
use yii\db\Query;

class m260508_141000_strip_seed_prefix_from_product_category_names extends Migration
{
    private const NAME_PREFIX_PATTERN = '/^seed_\d{8}_\d{6}_/u';

    public function safeUp()
    {
        $schema = $this->db->getTableSchema('{{%product_category}}', true);
        if ($schema === null) {
            return;
        }

        $query = (new Query())
            ->select(['id', 'name'])
            ->from('{{%product_category}}');

        foreach ($query->each(100, $this->db) as $row) {
            $oldName = (string) $row['name'];
            $newName = preg_replace(self::NAME_PREFIX_PATTERN, '', $oldName);
            if ($newName === $oldName) {
                continue;
            }

            $this->update('{{%product_category}}', ['name' => $newName], ['id' => (int) $row['id']]);
        }
    }

    public function safeDown()
    {
        // Irreversible: original prefix timestamps are not stored.
    }
}
