<?php

namespace api\models;

use common\models\Order as CommonOrder;

class Order extends CommonOrder
{
    public function fields()
    {
        return [
            'id',
            'customer_id',
            'store_id',
            'price_total',
            'placed_at',
            'status',
            'allow_update',
            'allow_delete',
            'created_at',
            'last_updated_at',
        ];
    }
}
