<?php

namespace common\models;

use common\models\BaseModel;

class Basketproduct extends BaseModel
{
    public $basket_product_id_list;

    public static function tableName()
    {
        return '{{%basket_product}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'product_id',
                        'basket_id',
                        'quantity',
                    ],
                    'integer'
                ],
                [
                    [
                        'product_id',
                        'basket_id',
                        'quantity',
                    ],
                    'required'
                ],
                [
                    [
                        'basket_id',
                        'product_id'
                    ],
                    'unique',
                    'targetAttribute' => ['basket_id', 'product_id']
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'basket_id' => 'Basket ID',
                'product_id' => 'Product ID',
                'quantity' => 'Item Quantity',
                'basketProductPrice' => 'Price (GBP)'
            ]
        );
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getBasketProductPrice()
    {
        return $this->product->price_in_gbp;
    }
}

// Model today: Unique (basket_id, product_id); basketProductPrice reads live product.price_in_gbp (not snapshotted).

// Recommended business logic:

// Quantity: Integer ≥ 1 (or ≥ 0 with delete-on-zero).
// Eligibility: Product must be is_active, sufficient stock, and fit store policy (single-store vs multi-store basket).
// Price snapshot: Decide unit price at add-to-basket vs always current price; avoid silent total changes if prices move.
// Recalc: Update parent Basket.price_total after any line change.

// Leave child models empty — use api\models\Basketproduct for caps, rate limits, etc.
