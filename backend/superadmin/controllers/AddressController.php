<?php

namespace superadmin\controllers;

use superadmin\models\Address;
use superadmin\models\filter\AddressFilter;

class AddressController extends DashboardController
{
    public $model_class = Address::class;
    public $filter_model_class = AddressFilter::class;
}
