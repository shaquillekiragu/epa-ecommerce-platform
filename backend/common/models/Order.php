<?php

namespace common\models;

use common\models\BaseModel;

class Order extends BaseModel
{
    public $order_id_list;

    public static function tableName()
    {
        return '{{%order}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'customer_id',
                        'store_id',
                        'price_total',
                    ],
                    'integer'
                ],
                [
                    [
                        'order_datetime',
                    ],
                    'safe'
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
                        'status',
                    ],
                    'in',
                    'range' => [
                        'pending_payment',
                        'payment_failed',
                        'paid',
                        'shipped',
                        'delivered',
                        'cancelled',
                        'refunded'
                    ]
                ],
                [
                    [
                        'customer_id',
                        'store_id',
                        'price_total',
                        'order_datetime',
                        'status',
                        'allow_update',
                        'allow_delete',
                    ],
                    'required'
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'customer_id' => 'Customer ID',
                'store_id' => 'Store ID',
                'price_total' => 'Order Price Total',
                'order_datetime' => 'Order Date & Time',
                'status' => 'Order Status',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }
}
