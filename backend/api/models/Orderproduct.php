<?php

namespace api\models;

use common\models\Orderproduct as CommonOrderproduct;

class Orderproduct extends CommonOrderproduct
{
    public function fields()
    {
        return [
            'id',
            'order_id',
            'product_id',
            'price_at_purchase_in_gbp',
            'quantity',
            'allow_update',
            'allow_delete',
            'created_at',
            'last_updated_at',
        ];
    }
}
