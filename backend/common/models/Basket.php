<?php

namespace common\models;

use yii\db\ActiveQuery;
use common\models\BaseModel;
use common\models\User;
use common\models\Basketproduct;
use common\models\Product;

class Basket extends BaseModel
{
    public static function tableName()
    {
        return '{{%basket}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'customer_id',
                    ],
                    'integer'
                ],
                [
                    [
                        'customer_id',
                    ],
                    'unique',
                    'message' => 'You already have an open basket.'
                ],
                [
                    [
                        'price_total',
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
                        'customer_id',
                        'price_total',
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
                'price_total' => 'Basket Price Total (GBP)',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }

    public function beforeSave($insert)
    {
        $this->price_total = $this->getBasketTotal();

        return parent::beforeSave($insert);
    }

    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    public function getCustomerName()
    {
        return $this->customer?->fullName;
    }

    public function getBasketProducts(): ActiveQuery
    {
        return $this->hasMany(Basketproduct::class, ['basket_id' => 'id']);
    }

    public function getBasketProductCount(): int
    {
        return count($this->basketProducts);
    }

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->via('basketProducts');
    }

    public function getBasketTotal(): float
    {
        $sub_total = 0;

        foreach ($this->basketProducts as $line_item) {
            $sub_total += $line_item->product->price_in_gbp * $line_item->quantity;
        }

        return round($sub_total, 2);
    }
}
