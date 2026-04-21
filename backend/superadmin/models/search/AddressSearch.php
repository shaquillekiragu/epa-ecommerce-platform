<?php

namespace superadmin\models\search;

use superadmin\models\Address;

class AddressSearch extends _BaseSearch
{
	protected string $model_class = Address::class;

	// search by: full_address
	// filter by: city, country
	// sort by: full_address, city, country
}
