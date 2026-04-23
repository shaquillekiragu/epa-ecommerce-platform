<?php

namespace superadmin\controllers;

use superadmin\models\Store;
use superadmin\models\search\StoreSearch;

class StoreController extends DashboardController
{
    public $model_class = Store::class;
    public $search_model_class = StoreSearch::class;
}
