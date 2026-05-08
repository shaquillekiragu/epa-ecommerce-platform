<?php

namespace api\models;

use yii\db\ActiveQuery;
use common\models\Store as CommonStore;

class Store extends CommonStore
{
    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'merchant_id',
            'allow_update',
            'allow_delete',
            'created_at',
            'last_updated_at',
        ];
    }

    /**
     * List filters from query string params (frontend / public API).
     *
     * Supported keys:
     * - `search` or `name` — substring match on store name (`name` alias for frontend convenience)
     * - `merchant_id` — exact merchant user id
     *
     * @param array<string, mixed> $params
     */
    public static function applyListFilters(ActiveQuery $query, array $params): void
    {
        $t = static::tableName();

        $term = trim((string) ($params['search'] ?? ''));
        if ($term === '') {
            $term = trim((string) ($params['name'] ?? ''));
        }
        if ($term !== '') {
            $query->andWhere(['like', $t . '.name', $term]);
        }

        $merchantId = $params['merchant_id'] ?? null;
        if ($merchantId !== null && $merchantId !== '' && (int) $merchantId > 0) {
            $query->andWhere([$t . '.merchant_id' => (int) $merchantId]);
        }
    }
}
