<?php

namespace superadmin\models\search;

use superadmin\models\User;

class UserSearch extends _BaseSearch
{
	protected string $model_class = User::class;

	// search by: fullName (Yii-enforced camelCase), email
	// filter by: role, country, is_account_active
	// sort by: fullName, last_name, email, role, country, is_account_active
}
