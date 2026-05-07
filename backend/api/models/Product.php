<?php

namespace api\models;

use common\models\Product as CommonProduct;

class Product extends CommonProduct
{
    public function fields()
    {
        return [
            'id',
            'store_id',
            'name',
            'slug',
            'product_category_id',
            'product_category_name' => static fn (self $model) => $model->productCategoryName,
            'description',
            'price_in_gbp',
            'number_in_stock',
            'sku_code',
            'weight_in_grams',
            'thumbnail',
            'seo_title',
            'is_active',
        ];
    }
}
