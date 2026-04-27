<?php

namespace superadmin\controllers;

use superadmin\models\Basketproduct;
use superadmin\models\filter\BasketproductFilter;

class BasketproductController extends DashboardController
{
    public $model_class = Basketproduct::class;
    public $filter_model_class = BasketproductFilter::class;
}
