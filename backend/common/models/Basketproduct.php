<?php

namespace common\models;

use Override;
use yii\db\ActiveQuery;
use common\models\BaseModel;

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
                    ['product_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Product::class,
                    'targetAttribute' => ['product_id' => 'id']
                ],
                [
                    ['basket_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Basket::class,
                    'targetAttribute' => ['basket_id' => 'id']
                ],
                [
                    ['quantity'],
                    'compare',
                    'compareValue' => 1,
                    'operator' => '>='
                ],
                [
                    ['quantity'],
                    'validateEligibility',
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

    public function getBasket(): ActiveQuery
    {
        return $this->hasOne(Basket::class, ['id' => 'basket_id']);
    }

    public function getBasketProductPrice(): float
    {
        return (float)$this->product->price_in_gbp;
    }

    public function getLineTotal(): float
    {
        return round(((float)$this->getBasketProductPrice()) * ((int)$this->quantity), 2);
    }

    public function validateEligibility(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $product = $this->product;
        if ($product === null) {
            $this->addError('product_id', 'Product not found.');
            return;
        }

        if (!$product->is_active) {
            $this->addError('product_id', 'Product is not available.');
            return;
        }

        $qty = (int) $this->$attribute;
        if ($qty > (int) $product->number_in_stock) {
            $this->addError($attribute, 'Insufficient stock.');
        }
    }

    #[Override]
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->recalcBasketTotal();
    }

    #[Override]
    public function afterDelete()
    {
        parent::afterDelete();
        $this->recalcBasketTotal();
    }

    private function recalcBasketTotal(): void
    {
        $basket = $this->basket;
        if ($basket === null) {
            return;
        }

        $basket->refresh();
        $basket->price_total = $basket->getBasketTotal();
        $basket->save(false, ['price_total']);
    }
}
