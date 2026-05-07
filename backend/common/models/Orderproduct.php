<?php

namespace common\models;

use Override;
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
                    ['product_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Product::class,
                    'targetAttribute' => ['product_id' => 'id']
                ],
                [
                    ['order_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Order::class,
                    'targetAttribute' => ['order_id' => 'id']
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
                    ['price_at_purchase_in_gbp'],
                    'compare',
                    'compareValue' => 0,
                    'operator' => '>='
                ],
                [
                    ['price_at_purchase_in_gbp'],
                    'validatePriceSnapshot',
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

    public function validatePriceSnapshot(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        if (!$this->isNewRecord && $this->isAttributeChanged($attribute)) {
            $this->addError($attribute, 'Price snapshot cannot be changed after checkout.');
        }
    }

    #[Override]
    public function beforeSave($insert)
    {
        if (!$insert) {
            $order = $this->order;
            if ($order !== null && $order->isFinanciallyLocked()) {
                $locked = ['product_id', 'quantity', 'price_at_purchase_in_gbp', 'order_id'];
                foreach ($locked as $attr) {
                    if ($this->isAttributeChanged($attr)) {
                        $this->addError($attr, 'Order items cannot be modified after the order is paid/shipped/delivered/cancelled/refunded.');
                        return false;
                    }
                }
            }
        }

        // If caller didn't set a snapshot price, default it from product price.
        if ($insert && (string) $this->price_at_purchase_in_gbp === '' && $this->product !== null) {
            $this->price_at_purchase_in_gbp = (float) $this->product->price_in_gbp;
        }

        return parent::beforeSave($insert);
    }

    #[Override]
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->recalcOrderTotal();
    }

    #[Override]
    public function afterDelete()
    {
        parent::afterDelete();
        $this->recalcOrderTotal();
    }

    private function recalcOrderTotal(): void
    {
        $order = $this->order;
        if ($order === null) {
            return;
        }

        $order->recalcAndPersistTotal();
    }
}
