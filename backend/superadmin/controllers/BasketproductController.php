<?php

namespace superadmin\controllers;

use superadmin\models\Basketproduct;
use superadmin\models\search\BasketproductSearch;

class BasketproductController extends DashboardController
{
    public $model_class = Basketproduct::class;
    public $search_model_class = BasketproductSearch::class;
}
