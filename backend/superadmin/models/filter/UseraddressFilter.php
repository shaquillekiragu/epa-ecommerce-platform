<?php

namespace superadmin\models\filter;

use superadmin\models\Useraddress;

class UseraddressFilter extends _BaseFilter
{
	protected string $model_class = Useraddress::class;

	// filter by: user_id, address_id
}
