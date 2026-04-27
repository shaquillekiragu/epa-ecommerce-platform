<?php

namespace superadmin\controllers;

use superadmin\models\User;
use superadmin\models\filter\UserFilter;

class UserController extends DashboardController
{
    public $model_class = User::class;
    public $filter_model_class = UserFilter::class;
}
