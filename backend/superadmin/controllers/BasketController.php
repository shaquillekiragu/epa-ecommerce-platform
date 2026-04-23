<?php

namespace superadmin\controllers;

use superadmin\models\Basket;
use superadmin\models\search\BasketSearch;

class BasketController extends DashboardController
{
    public $model_class = Basket::class;
    public $search_model_class = BasketSearch::class;
}
