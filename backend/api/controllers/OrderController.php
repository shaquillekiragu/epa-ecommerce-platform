<?php

namespace api\controllers;

use api\models\Order;

class OrderController extends _ApiController
{
    public $modelClass = Order::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
