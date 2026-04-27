<?php

namespace common\models;

use common\models\BaseModel;

class Orderproduct extends BaseModel
{
    public $order_product_id_list;

    public static function tableName()
    {
        return '{{%order_product}}';
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
                        'allow_update',
                        'allow_delete',
                    ],
                    'boolean'
                ],
                [
                    [
                        'product_id',
                        'order_id',
                        'price_at_purchase_in_gbp',
                        'quantity',
                        'allow_update',
                        'allow_delete',
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

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'order_id' => 'Order ID',
                'product_id' => 'Product ID',
                'price_at_purchase_in_gbp' => 'Price at Purchase (GBP)',
                'quantity' => 'Item Quantity',
                'allow_update' => 'Allow Update',
                'allow_delete' => 'Allow Delete',
            ]
        );
    }
}
