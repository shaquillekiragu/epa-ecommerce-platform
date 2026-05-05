<?php

namespace api\models;

use common\models\Basket as CommonBasket;

class Basket extends CommonBasket
{
    public function fields()
    {
        return [
            'id',
            'customer_id',
            'customer_name' => static fn (self $model) => $model->customerName,
            'price_total',
            'allow_update',
            'allow_delete',
            'created_at',
            'last_updated_at',
        ];
    }
}
