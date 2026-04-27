<?php

namespace superadmin\controllers;

use superadmin\models\Orderproduct;
use superadmin\models\filter\OrderproductFilter;

class OrderproductController extends DashboardController
{
    public $model_class = Orderproduct::class;
    public $filter_model_class = OrderproductFilter::class;
}
