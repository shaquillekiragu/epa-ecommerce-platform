<?php

namespace superadmin\controllers;

use superadmin\models\Order;
use superadmin\models\search\OrderSearch;

class OrderController extends CrudController
{
    public $model_class = Order::class;
    public $search_model_class = OrderSearch::class;
}
