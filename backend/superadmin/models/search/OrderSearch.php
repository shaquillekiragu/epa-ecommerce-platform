<?php

namespace superadmin\models\search;

use superadmin\models\Order;

class OrderSearch extends _BaseSearch
{
	protected string $model_class = Order::class;

	// search by: customer_name
	// filter by: store_name, status
	// sort by: customer_name, store_name, price_total, status
}
