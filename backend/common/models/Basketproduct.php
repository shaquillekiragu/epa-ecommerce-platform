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
                        'allow_update',
                        'allow_delete',
                    ],
                    'boolean'
                ],
                [
                    [
                        'product_id',
                        'basket_id',
                        'quantity',
                        'allow_update',
                        'allow_delete',
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
                'product_id' => 'Product id',
                'quantity' => 'Item Quantity',
                'allow_update' => 'Allow Update',
                'allow_delete' => 'Allow Delete',
            ]
        );
    }
}
