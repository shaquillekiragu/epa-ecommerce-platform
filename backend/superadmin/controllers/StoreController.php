<?php

namespace superadmin\controllers;

use superadmin\models\Store;
use superadmin\models\filter\StoreFilter;

class StoreController extends DashboardController
{
    public $model_class = Store::class;
    public $filter_model_class = StoreFilter::class;
}
