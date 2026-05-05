<?php

namespace api\models;

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
}
