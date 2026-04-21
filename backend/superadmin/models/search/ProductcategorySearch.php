<?php

namespace superadmin\models\search;

use superadmin\models\Productcategory;

class ProductcategorySearch extends _BaseSearch
{
	protected string $model_class = Productcategory::class;

	// search by: category_name
	// filter by: N/A
	// sort by: category_name
}
