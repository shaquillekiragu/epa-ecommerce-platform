<?php

use yii\db\Migration;
use yii\helpers\Console;

/**
 * Resets the password for an existing superadmin-assigned user.
 */
class m260416_000004_reset_superadmin_password extends Migration
{
    public function safeUp()
    {
        $assignment = (new \yii\db\Query())
            ->select(['user_id'])
            ->from('{{%auth_assignment}}')
            ->where(['item_name' => 'superadmin'])
            ->orderBy(['created_at' => SORT_ASC, 'user_id' => SORT_ASC])
            ->one($this->db);

        if (!$assignment) {
            throw new \RuntimeException('No RBAC assignment found for role "superadmin".');
        }

        $userId = (int) $assignment['user_id'];

        $user = (new \yii\db\Query())
            ->select(['id', 'email'])
            ->from('{{%user}}')
            ->where(['id' => $userId])
            ->one($this->db);

        if (!$user) {
            throw new \RuntimeException("User {$userId} not found in {{%user}}.");
        }

        $newPlainPassword = 'Superadmin123!';
        $newHash = \Yii::$app->security->generatePasswordHash($newPlainPassword);

        $this->update(
            '{{%user}}',
            [
                'hashed_password' => $newHash,
                'is_active' => 1,
                'deactivated_at' => null,
            ],
            ['id' => $userId]
        );

        Console::output('Reset superadmin user password:');
        Console::output('  user_id: ' . $userId);
        Console::output('  email: ' . $user['email']);
        Console::output('  password: ' . $newPlainPassword);
    }

    public function safeDown()
    {
        // Non-destructive: do not revert passwords.
        return true;
    }
}
