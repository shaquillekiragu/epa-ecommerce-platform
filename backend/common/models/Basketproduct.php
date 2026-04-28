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
