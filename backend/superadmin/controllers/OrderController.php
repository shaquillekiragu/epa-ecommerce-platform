<?php

namespace superadmin\controllers;

use superadmin\models\Order;
use superadmin\models\filter\OrderFilter;

class OrderController extends DashboardController
{
    public $model_class = Order::class;
    public $filter_model_class = OrderFilter::class;
}
