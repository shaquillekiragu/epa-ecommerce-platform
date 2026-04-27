<?php

use yii\db\Migration;

/**
 * Prevents deleting the RBAC-assigned superadmin user by default.
 */
class m260427_132100_set_superadmin_allow_delete_false extends Migration
{
    public function safeUp()
    {
        $superadminUserId = (new \yii\db\Query())
            ->select(['user_id'])
            ->from('{{%auth_assignment}}')
            ->where(['item_name' => 'superadmin'])
            ->orderBy(['created_at' => SORT_ASC, 'user_id' => SORT_ASC])
            ->scalar($this->db);

        if ($superadminUserId === false) {
            return;
        }

        $this->update(
            '{{%user}}',
            ['allow_delete' => false],
            ['id' => (int) $superadminUserId]
        );
    }

    public function safeDown()
    {
        $superadminUserId = (new \yii\db\Query())
            ->select(['user_id'])
            ->from('{{%auth_assignment}}')
            ->where(['item_name' => 'superadmin'])
            ->orderBy(['created_at' => SORT_ASC, 'user_id' => SORT_ASC])
            ->scalar($this->db);

        if ($superadminUserId === false) {
            return;
        }

        $this->update(
            '{{%user}}',
            ['allow_delete' => true],
            ['id' => (int) $superadminUserId]
        );
    }
}
