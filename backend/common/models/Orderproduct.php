<?php

namespace common\models;

use common\models\BaseModel;

class Orderproduct extends BaseModel
{
    public $order_product_id_list;

    public static function tableName()
    {
        return 'order_product';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'product_id',
                        'order_id',
                        'quantity',
                        'created_by',
                        'last_updated_by',
                    ],
                    'integer'
                ],
                [
                    [
                        'price_at_purchase_in_gbp',
                    ],
                    'number'
                ],
                [
                    [
                        'created_at',
                        'last_updated_at',
                    ],
                    'safe'
                ],
                [
                    [
                        'product_id',
                        'order_id',
                        'price_at_purchase_in_gbp',
                        'quantity',
                        'created_by',
                        'last_updated_by',
                    ],
                    'required'
                ],
                [
                    [
                        'order_id',
                        'product_id'
                    ],
                    'unique',
                    'targetAttribute' => ['order_id', 'product_id']
                ],
            ]
        );
    }
}
