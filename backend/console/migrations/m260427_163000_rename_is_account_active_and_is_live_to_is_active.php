<?php

use yii\db\Migration;

/**
 * Renames:
 * - user.is_account_active -> user.is_active
 * - product.is_live -> product.is_active
 *
 * Guarded so it can run safely on partially-migrated databases.
 */
class m260427_163000_rename_is_account_active_and_is_live_to_is_active extends Migration
{
    public function safeUp()
    {
        $userTable = $this->db->getTableSchema('{{%user}}', true);
        if ($userTable !== null) {
            $hasOld = isset($userTable->columns['is_account_active']);
            $hasNew = isset($userTable->columns['is_active']);

            if ($hasOld && !$hasNew) {
                $this->renameColumn('{{%user}}', 'is_account_active', 'is_active');
            }
        }

        $productTable = $this->db->getTableSchema('{{%product}}', true);
        if ($productTable !== null) {
            $hasOld = isset($productTable->columns['is_live']);
            $hasNew = isset($productTable->columns['is_active']);

            if ($hasOld && !$hasNew) {
                $this->renameColumn('{{%product}}', 'is_live', 'is_active');
            }
        }
    }

    public function safeDown()
    {
        $productTable = $this->db->getTableSchema('{{%product}}', true);
        if ($productTable !== null) {
            $hasOld = isset($productTable->columns['is_live']);
            $hasNew = isset($productTable->columns['is_active']);

            if (!$hasOld && $hasNew) {
                $this->renameColumn('{{%product}}', 'is_active', 'is_live');
            }
        }

        $userTable = $this->db->getTableSchema('{{%user}}', true);
        if ($userTable !== null) {
            $hasOld = isset($userTable->columns['is_account_active']);
            $hasNew = isset($userTable->columns['is_active']);

            if (!$hasOld && $hasNew) {
                $this->renameColumn('{{%user}}', 'is_active', 'is_account_active');
            }
        }
    }
}

