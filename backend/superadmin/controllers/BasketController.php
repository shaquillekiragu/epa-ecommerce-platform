<?php

namespace superadmin\controllers;

use superadmin\models\Basket;
use superadmin\models\filter\BasketFilter;

class BasketController extends DashboardController
{
    public $model_class = Basket::class;
    public $filter_model_class = BasketFilter::class;
}
