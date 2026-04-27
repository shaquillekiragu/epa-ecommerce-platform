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
                        'is_active',
                    ],
                    'boolean'
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
                        'is_active',
                        'allow_update',
                        'allow_delete',
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
        return array_merge(
            parent::attributeLabels(),
            [
                'store_id' => 'Store ID',
                'product_name' => 'Product Name',
                'product_category_id' => 'Product Category ID',
                'price_in_gbp' => 'Price (GBP)',
                'number_in_stock' => 'Stock Quantity',
                'sku_code' => 'SKU Code',
                'weight_in_grams' => 'Weight (g)',
                'thumbnail' => 'Thumbnail',
                'is_active' => 'Is Active',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }
}
