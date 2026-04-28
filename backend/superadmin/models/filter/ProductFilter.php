<?php

namespace superadmin\models\filter;

use superadmin\models\Product;

class ProductFilter extends _BaseFilter
{
	protected string $model_class = Product::class;

	// filter by: product_category_name, store_name
}
