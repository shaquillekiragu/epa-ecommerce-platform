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
                        'price_total',
                    ],
                    'integer'
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
                'price_total' => 'Basket Price Total',
                'allow_update' => 'Allow Update',
                'allow_delete' => 'Allow Delete',
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
