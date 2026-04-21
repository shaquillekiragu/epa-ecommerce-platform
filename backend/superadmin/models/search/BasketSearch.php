<?php

namespace superadmin\models\search;

use superadmin\models\Basket;

class BasketSearch extends _BaseSearch
{
	protected string $model_class = Basket::class;

	// search by: customer_name
	// filter by: N/A
	// sort by: customer_name, price_total
}
