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
