<?php

namespace superadmin\models\search;

use superadmin\models\Basketproduct;

class BasketproductSearch extends _BaseSearch
{
	protected string $model_class = Basketproduct::class;

	// search by: N/A
	// filter by: basket_id, product_id
	// sort by: basket_id, product_id, quantity
}
