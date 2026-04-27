<?php

namespace superadmin\controllers;

use superadmin\models\Useraddress;
use superadmin\models\filter\UseraddressFilter;

class UseraddressController extends DashboardController
{
    public $model_class = Useraddress::class;
    public $filter_model_class = UseraddressFilter::class;
}
