<?php

namespace api\controllers;

use api\models\Order;

class OrderController extends _ApiController
{
    public $modelClass = Order::class;

    public function actions()
    {
        $actions = parent::actions();

        // Read-only until auth + ownership scoping is implemented.
        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
