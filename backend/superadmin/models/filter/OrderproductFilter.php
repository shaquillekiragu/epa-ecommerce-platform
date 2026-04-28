<?php

namespace superadmin\models\filter;

use superadmin\models\Orderproduct;

class OrderproductFilter extends _BaseFilter
{
	protected string $model_class = Orderproduct::class;

	// filter by: order_id, product_id
}
