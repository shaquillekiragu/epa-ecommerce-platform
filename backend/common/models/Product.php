<?php

namespace common\models;

use common\models\BaseModel;

class Product extends BaseModel
{
    public $product_id_list;

    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'store_id',
                        'product_category_id',
                        'number_in_stock',
                        'weight_in_grams',
                        'created_by',
                        'last_updated_by',
                    ],
                    'integer'
                ],
                [
                    [
                        'price_in_gbp',
                    ],
                    'number'
                ],
                [
                    [
                        'is_live',
                    ],
                    'boolean'
                ],
                [
                    [
                        'product_name',
                        'thumbnail',
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    [
                        'sku_code',
                    ],
                    'string',
                    'length' => 64
                ],
                [
                    [
                        'created_at',
                        'last_updated_at',
                    ],
                    'safe'
                ],
                [
                    [
                        'store_id',
                        'product_name',
                        'product_category_id',
                        'price_in_gbp',
                        'number_in_stock',
                        'sku_code',
                        'weight_in_grams',
                        'thumbnail',
                        'created_by',
                        'last_updated_by',
                    ],
                    'required'
                ],
                [
                    [
                        'product_name'
                    ],
                    'unique'
                ],
            ]
        );
    }
}
