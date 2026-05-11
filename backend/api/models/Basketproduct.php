<?php

namespace api\models;

use common\models\Basketproduct as CommonBasketproduct;

class Basketproduct extends CommonBasketproduct
{
    public function fields()
    {
        return [
            'id',
            'basket_id',
            'product_id',
            'quantity',
            'basket_product_price' => static fn (self $model) => $model->basketProductPrice,
            'created_at',
            'last_updated_at',
        ];
    }
}
