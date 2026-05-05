<?php

namespace common\models;

use yii\db\ActiveQuery;
use common\models\BaseModel;
use common\models\User;

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
                    ],
                    'integer'
                ],
                [
                    [
                        'price_total',
                    ],
                    'number'
                ],
                [
                    [
                        'placed_at',
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
                        'placed_at',
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
                'price_total' => 'Order Price Total (GBP)',
                'placed_at' => 'Order placed at',
                'status' => 'Order Status',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }

    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    public function getStore(): ActiveQuery
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }

    public function getCustomerName(): string | null
    {
        $customer = User::findOne($this->customer_id);
        return $customer->fullName;
    }

    public function getCustomerEmail(): string | null
    {
        $customer = User::findOne($this->customer_id);
        return $customer->email;
    }

    public function getBillingAddress(): string | null
    {
        $customer = User::findOne($this->customer_id);
        return $customer->billingAddress;
    }

    public function getShippingAddress(): string | null
    {
        $customer = User::findOne($this->customer_id);
        return $customer->shippingAddress;
    }

    public function getOrderProducts(): ActiveQuery
    {
        return $this->hasMany(Orderproduct::class, ['order_id' => 'id']);
    }

    public function getOrderProductCount(): int
    {
        return count($this->orderProducts);
    }

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->via('orderProducts');
    }

    public function getOrderTotal(): float
    {
        $sub_total = 0;

        foreach ($this->orderProducts as $line_item) {
            $sub_total += $line_item->price_at_purchase_in_gbp * $line_item->quantity;
        }

        return round($sub_total, 2);
    }
}

// Model today: customer_id, store_id, price_total, placed_at, status enum; allow_* flags.

// Recommended business logic:

// Status machine: Allow only legal transitions (e.g. pending_payment → paid); centralize in model or domain service.
// Immutability: After paid/shipped restrict field changes; financial fields immutable except admin correction with audit.
// Totals: price_total should match sum of Orderproduct lines (+ tax/shipping when added).
// Timestamps: Set placed_at on create if omitted; document timezone policy.
// Cancellation / refund: Define stock restoration and payment linkage when those flows exist.

// Leave child models empty — use api\models\Order for customer-scoped reads; superadmin\models\Order for admin overrides with logging in services.
