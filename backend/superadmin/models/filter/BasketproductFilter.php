<?php

namespace superadmin\models\filter;

use superadmin\models\Basketproduct;

class BasketproductFilter extends _BaseFilter
{
	protected string $model_class = Basketproduct::class;

	// filter by: basket_id, product_id
}
