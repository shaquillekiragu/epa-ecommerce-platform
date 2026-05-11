<?php

namespace common\models;

use Yii;
use Override;
use yii\db\ActiveQuery;
use common\models\BaseModel;
use common\models\User;

class Order extends BaseModel
{
    public const STATUS_PENDING_PAYMENT = 'pending_payment';
    public const STATUS_PAYMENT_FAILED = 'payment_failed';
    public const STATUS_PAID = 'paid';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REFUNDED = 'refunded';

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
                    ['stripe_payment_intent_id'],
                    'string',
                    'max' => 255,
                ],
                [
                    [
                        'status',
                    ],
                    'in',
                    'range' => [
                        self::STATUS_PENDING_PAYMENT,
                        self::STATUS_PAYMENT_FAILED,
                        self::STATUS_PAID,
                        self::STATUS_SHIPPED,
                        self::STATUS_DELIVERED,
                        self::STATUS_CANCELLED,
                        self::STATUS_REFUNDED,
                    ]
                ],
                [
                    ['status'],
                    'validateStatusTransition',
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

    #[Override]
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        if ($this->hasAttribute('placed_at') && empty($this->placed_at)) {
            $this->placed_at = $now;
        }

        return true;
    }

    public function beforeSave($insert)
    {
        if (!$insert && $this->isFinanciallyLocked()) {
            $locked = [
                'customer_id',
                'store_id',
                'price_total',
                'placed_at',
            ];
            foreach ($locked as $attr) {
                if ($this->hasAttribute($attr) && $this->isAttributeChanged($attr)) {
                    $this->addError($attr, 'Order cannot be modified after it is paid/shipped/delivered/cancelled/refunded.');
                    return false;
                }
            }
        }

        if (!$insert && $this->hasLineItems()) {
            $this->price_total = $this->getOrderTotal();
        }

        return parent::beforeSave($insert);
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
        return $this->customer?->fullName;
    }

    public function getCustomerEmail(): string | null
    {
        return $this->customer?->email;
    }

    public function getBillingAddress(): string | null
    {
        return $this->customer?->billingAddress;
    }

    public function getShippingAddress(): string | null
    {
        return $this->customer?->shippingAddress;
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

    public function getIsPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function validateStatusTransition(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        if ($this->isNewRecord) {
            return;
        }

        if (!$this->isAttributeChanged($attribute)) {
            return;
        }

        $from = (string) $this->getOldAttribute($attribute);
        $to = (string) $this->$attribute;

        $allowed = self::allowedTransitions();

        if (!isset($allowed[$from]) || !in_array($to, $allowed[$from], true)) {
            $this->addError($attribute, "Illegal status transition: {$from} → {$to}.");
        }
    }

    public static function allowedTransitions(): array
    {
        return [
            self::STATUS_PENDING_PAYMENT => [self::STATUS_PAID, self::STATUS_PAYMENT_FAILED, self::STATUS_CANCELLED],
            self::STATUS_PAYMENT_FAILED => [self::STATUS_PENDING_PAYMENT, self::STATUS_CANCELLED],
            self::STATUS_PAID => [self::STATUS_SHIPPED, self::STATUS_CANCELLED, self::STATUS_REFUNDED],
            self::STATUS_SHIPPED => [self::STATUS_DELIVERED, self::STATUS_REFUNDED],
            self::STATUS_DELIVERED => [self::STATUS_REFUNDED],
            self::STATUS_CANCELLED => [],
            self::STATUS_REFUNDED => [],
        ];
    }

    public function transitionTo(string $newStatus, bool $save = true): bool
    {
        $this->status = $newStatus;
        return $save ? $this->save() : $this->validate();
    }

    public function cancel(bool $restoreStock = true): bool
    {
        return $this->changeTerminalStatus(self::STATUS_CANCELLED, $restoreStock);
    }

    public function refund(bool $restoreStock = true): bool
    {
        return $this->changeTerminalStatus(self::STATUS_REFUNDED, $restoreStock);
    }

    private function changeTerminalStatus(string $terminalStatus, bool $restoreStock): bool
    {
        $db = Yii::$app->db;
        
        return (bool) $db->transaction(function () use ($terminalStatus, $restoreStock) {
            if (!$this->transitionTo($terminalStatus, false)) {
                return false;
            }

            if (!$this->save(false, ['status'])) {
                return false;
            }

            if ($restoreStock) {
                foreach ($this->orderProducts as $line) {
                    $product = $line->product;

                    if ($product === null) {
                        continue;
                    }

                    $product->number_in_stock = (int) $product->number_in_stock + (int) $line->quantity;
                    $product->save(false, ['number_in_stock']);
                }
            }

            return true;
        });
    }

    public function recalcAndPersistTotal(): void
    {
        $this->refresh();
        $this->price_total = $this->getOrderTotal();
        $this->save(false, ['price_total']);
    }

    private function hasLineItems(): bool
    {
        if ($this->isNewRecord) {
            return false;
        }

        return Orderproduct::find()->where(['order_id' => $this->id])->exists();
    }

    public function isFinanciallyLocked(): bool
    {
        return in_array((string) $this->status, [
            self::STATUS_PAID,
            self::STATUS_SHIPPED,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED,
            self::STATUS_REFUNDED,
        ], true);
    }
}
