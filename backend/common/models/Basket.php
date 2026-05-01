<?php

namespace common\models;

use common\models\BaseModel;
use common\models\User;

class Basket extends BaseModel
{
    public $basket_id_list;

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

    public function getCustomerName()
    {
        $customer = User::findOne($this->customer_id);
        if (!$customer) {
            return null;
        }

        return $customer->fullName;
    }
}

// Model today: customer_id, price_total required; getCustomerName uses fullName on User (getter is getFullName — verify magic property).

// Recommended business logic:

// Totals: Derive price_total from Basketproduct lines; do not trust client-submitted totals; recalc after line changes.
// Ownership: Optionally one open basket per customer — enforce via unique constraint or app check.
// Currency: Keep aligned with product/order (GBP).

// Leave child models empty — use api\models\Basket for customer-only rules (e.g. cannot set customer_id to another user).
