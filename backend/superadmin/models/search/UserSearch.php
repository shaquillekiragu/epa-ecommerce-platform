<?php

namespace superadmin\models\search;

use superadmin\models\User;

class UserSearch extends _BaseSearch
{
	protected string $model_class = User::class;
}
