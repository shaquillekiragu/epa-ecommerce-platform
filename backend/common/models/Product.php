<?php

namespace common\models;

use common\models\BaseModel;

class Product extends BaseModel
{
    public $product_id_list;

    public static function tableName()
    {
        return '{{%product}}';
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
                        'store_id',
                        'product_name',
                        'product_category_id',
                        'price_in_gbp',
                        'number_in_stock',
                        'sku_code',
                        'weight_in_grams',
                        'thumbnail',
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

    public function attributeLabels()
    {
        return [
            'store_id' => 'Store ID',
            'product_name' => 'Product Name',
            'product_category_id' => 'Product Category ID',
            'price_in_gbp' => 'Price (GBP)',
            'number_in_stock' => 'Stock Quantity',
            'sku_code' => 'SKU Code',
            'weight_in_grams' => 'Weight (g)',
            'thumbnail' => 'Thumbnail',
            'is_live' => 'Is Live',
        ];
    }
}
