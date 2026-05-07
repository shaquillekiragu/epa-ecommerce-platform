<?php

namespace common\models;

use common\models\BaseModel;
use yii\db\ActiveQuery;

class Basketproduct extends BaseModel
{
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
                    ['quantity'],
                    'compare',
                    'compareValue' => 1,
                    'operator' => '>='
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

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getBasketProductPrice(): float
    {
        return (float)$this->product->price_in_gbp;
    }

    public function getLineTotal(): float
    {
        return round(((float)$this->getBasketProductPrice()) * ((int)$this->quantity), 2);
    }
}

// Eligibility: Product must be is_active, sufficient stock, and fit store policy (single-store vs multi-store basket).
// Price snapshot: Decide unit price at add-to-basket vs always current price; avoid silent total changes if prices move.
// Recalc: Update parent Basket.price_total after any line change.
