<?php

namespace console\seeders;

use Yii;
use yii\db\Connection;
use yii\db\Query;

abstract class BaseSeeder
{
    protected Connection $db;
    protected string $seed_run_prefix;

    public function __construct(Connection $db, ?int $seed = null)
    {
        $this->db = $db;

        if ($seed !== null) {
            mt_srand($seed);
        }

        $this->seed_run_prefix = 'seed_' . date('Ymd_His') . '_';
    }

    protected function insertData(array $batched_array, string $db_table_name, bool $return_ids = false): array
    {
        $id_list = [];

        foreach ($batched_array as $batch) {
            foreach ($batch as $row) {
                $this->db->createCommand()->insert("{{%{$db_table_name}}}", $row)->execute();

                if ($return_ids) {
                    $id_list[] = (int) $this->db->getLastInsertID();
                }
            }
        }

        return $id_list;
    }

    /**
     * @param callable|null $row_inserted_callback Called after each row insert.
     */
    protected function insertDataWithCallback(
        array $batched_array,
        string $db_table_name,
        bool $return_ids = false,
        ?callable $row_inserted_callback = null
    ): array {
        $id_list = [];

        foreach ($batched_array as $batch) {
            foreach ($batch as $row) {
                $this->db->createCommand()->insert("{{%{$db_table_name}}}", $row)->execute();

                if ($return_ids) {
                    $id_list[] = (int) $this->db->getLastInsertID();
                }

                if ($row_inserted_callback !== null) {
                    $row_inserted_callback();
                }
            }
        }

        return $id_list;
    }

    protected function applyAuditActor(array $rows, int $actor_id): array
    {
        foreach ($rows as $i => $row) {
            $rows[$i]['created_by'] = $actor_id;
            $rows[$i]['last_updated_by'] = $actor_id;
        }

        return $rows;
    }

    protected function getSuperadminUserId(): ?int
    {
        $user_id = (new Query())
            ->select(['user_id'])
            ->from('{{%auth_assignment}}')
            ->where(['item_name' => 'superadmin'])
            ->orderBy(['created_at' => SORT_ASC, 'user_id' => SORT_ASC])
            ->scalar($this->db);

        return $user_id !== false ? (int) $user_id : null;
    }

    /**
     * Ensures there is a valid superadmin user_id that exists in {{%user}}.
     * This is important after running seed/clear-all, which truncates {{%user}}
     * but does not clear RBAC tables.
     */
    protected function ensureSuperadminUserId(): int
    {
        $assigned_user_id = $this->getSuperadminUserId();

        if ($assigned_user_id !== null) {
            $exists = (new Query())
                ->from('{{%user}}')
                ->where(['id' => $assigned_user_id])
                ->exists($this->db);

            if ($exists) {
                return $assigned_user_id;
            }
        }

        // Remove stale assignments for superadmin.
        $this->db->createCommand()
            ->delete('{{%auth_assignment}}', ['item_name' => 'superadmin'])
            ->execute();

        $email = 'superadmin_' . bin2hex(random_bytes(4)) . '@example.com';
        $plain_password = 'Superadmin123!';
        $password_hash = Yii::$app->security->generatePasswordHash($plain_password);

        // user.created_by / last_updated_by are nullable (self-referencing FK), so we can insert safely.
        $this->db->createCommand()->insert('{{%user}}', [
            'role' => 'merchant',
            'first_name' => 'Super',
            'middle_names' => null,
            'last_name' => 'Admin',
            'email' => $email,
            'hashed_password' => $password_hash,
            'date_of_birth' => '1990-01-01',
            'country' => 'GB',
            'mobile_number' => '07000000000',
            'is_active' => 1,
            'deactivated_at' => null,
            'allow_update' => 1,
            'allow_delete' => 0,
            'created_by' => null,
            'last_updated_by' => null,
        ])->execute();

        $new_user_id = (int) $this->db->getLastInsertID();

        /** @var \yii\rbac\ManagerInterface $auth */
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('superadmin');
        if ($role === null) {
            throw new \RuntimeException('RBAC role "superadmin" not found. Run RBAC migrations first.');
        }

        $auth->assign($role, (string) $new_user_id);

        return $new_user_id;
    }

    protected function hashAllPasswords(array $users): array
    {
        return array_map(static function (array $user): array {
            if (isset($user['hashed_password'])) {
                $user['hashed_password'] = Yii::$app->security->generatePasswordHash($user['hashed_password']);
            }
            return $user;
        }, $users);
    }
}
