<?php

namespace superadmin\models\search;

use superadmin\models\Product;

class ProductSearch extends _BaseSearch
{
	protected string $model_class = Product::class;

	// search by: product_name, sku_code, seo_title
	// filter by: product_category_name, store_name
	// sort by: product_name, product_category_name, store_name, price_in_gbp, number_in_stock, sku_code, weight_in_grams
}
