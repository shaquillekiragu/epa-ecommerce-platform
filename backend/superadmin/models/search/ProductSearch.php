<?php

namespace superadmin\models\search;

use superadmin\models\Product;

class ProductSearch extends _BaseSearch
{
	protected string $model_class = Product::class;

	// search by: product_name, sku_code, seo_title
}
