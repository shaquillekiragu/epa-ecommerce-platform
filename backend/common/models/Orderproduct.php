<?php

namespace common\models;

use yii\db\ActiveQuery;
use common\models\BaseModel;

class Orderproduct extends BaseModel
{
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
                        'product_id',
                        'order_id',
                        'price_at_purchase_in_gbp',
                        'quantity',
                    ],
                    'required'
                ],
                [
                    ['quantity'],
                    'compare',
                    'compareValue' => 1,
                    'operator' => '>='
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
            ]
        );
    }

    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getLineTotal(): float
    {
        return round(((float)$this->price_at_purchase_in_gbp) * ((int)$this->quantity), 2);
    }
}

// Model today: Unique (order_id, product_id); price_at_purchase_in_gbp snapshots line price.

// Recommended business logic:

// Quantity: Same as basket lines; ≥ 1.
// Price integrity: Freeze price_at_purchase_in_gbp at checkout from product/promotions; validate at creation, not on later reads.
// Immutability: No edits after order paid except superadmin correction with trail.

// Leave child models empty — use api\models\Orderproduct for read-only customer exposure if needed.
