<?php

use yii\db\Migration;
use yii\helpers\Console;
use yii\rbac\DbManager;

/**
 * Seeds a random superadmin user if none exists.
 */
class m260416_000003_seed_random_superadmin_user extends Migration
{
    public function safeUp()
    {
        $superadminAlreadyAssigned = (new \yii\db\Query())
            ->from('{{%auth_assignment}}')
            ->where(['item_name' => 'superadmin'])
            ->exists($this->db);

        if ($superadminAlreadyAssigned) {
            return;
        }

        $email = 'superadmin_' . bin2hex(random_bytes(4)) . '@example.com';
        $plainPassword = bin2hex(random_bytes(8));
        $passwordHash = \Yii::$app->security->generatePasswordHash($plainPassword);

        // Create a valid user row for this project schema
        $this->insert('{{%user}}', [
            'role' => 'merchant',
            'first_name' => 'Super',
            'middle_names' => null,
            'last_name' => 'Admin',
            'email' => $email,
            'hashed_password' => $passwordHash,
            'date_of_birth' => '1990-01-01',
            'country' => 'GB',
            'mobile_number' => '07000000000',
            'is_account_active' => 1,
            'deleted_at' => null,
            'created_by' => null,
            'last_updated_by' => null,
        ]);

        $userId = (string) $this->db->getLastInsertID();

        /** @var DbManager $auth */
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole('superadmin');
        if ($role === null) {
            throw new \RuntimeException('RBAC role "superadmin" not found. Run RBAC seed migration first.');
        }

        $auth->assign($role, $userId);

        // Make credentials visible when running migrations locally
        Console::output('Seeded superadmin user:');
        Console::output("  email: {$email}");
        Console::output("  password: {$plainPassword}");
    }

    public function safeDown()
    {
        // Non-destructive: do not delete users.
        return true;
    }
}
