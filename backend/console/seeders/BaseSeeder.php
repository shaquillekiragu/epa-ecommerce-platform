<?php

namespace console\seeders;

use Yii;
use yii\db\Connection;
use yii\db\Query;

abstract class BaseSeeder
{
    protected Connection $db;
    protected string $seedRunPrefix;

    public function __construct(Connection $db, ?int $seed = null)
    {
        $this->db = $db;

        if ($seed !== null) {
            mt_srand($seed);
        }

        $this->seedRunPrefix = 'seed_' . date('Ymd_His') . '_';
    }

    protected function insertData(array $batchedArray, string $dbTableName, bool $returnIds = false): array
    {
        $idList = [];

        foreach ($batchedArray as $batch) {
            foreach ($batch as $row) {
                $this->db->createCommand()->insert("{{%{$dbTableName}}}", $row)->execute();

                if ($returnIds) {
                    $idList[] = (int) $this->db->getLastInsertID();
                }
            }
        }

        return $idList;
    }

    protected function applyAuditActor(array $rows, int $actorId): array
    {
        foreach ($rows as $i => $row) {
            if (array_key_exists('created_by', $row)) {
                $rows[$i]['created_by'] = $actorId;
            }

            if (array_key_exists('last_updated_by', $row)) {
                $rows[$i]['last_updated_by'] = $actorId;
            }
        }

        return $rows;
    }

    protected function getSuperadminUserId(): ?int
    {
        $userId = (new Query())
            ->select(['user_id'])
            ->from('{{%auth_assignment}}')
            ->where(['item_name' => 'superadmin'])
            ->orderBy(['created_at' => SORT_ASC, 'user_id' => SORT_ASC])
            ->scalar($this->db);

        return $userId !== false ? (int) $userId : null;
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
