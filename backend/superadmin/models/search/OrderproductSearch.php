<?php

namespace superadmin\models\search;

use superadmin\models\Orderproduct;

class OrderproductSearch extends _BaseSearch
{
	protected string $model_class = Orderproduct::class;

	// search by: N/A
	// filter by: order_id, product_id
	// sort by: order_id, product_id, quantity, price_at_purchase_in_gbp
}
