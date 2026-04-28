<?php

namespace superadmin\models\filter;

use superadmin\models\Address;

class AddressFilter extends _BaseFilter
{
	protected string $model_class = Address::class;

	// filter by: city, country
}
