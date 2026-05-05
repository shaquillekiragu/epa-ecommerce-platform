<?php

namespace api\controllers;

use api\models\Basket;

class BasketController extends _ApiController
{
    public $modelClass = Basket::class;

    public function actions()
    {
        $actions = parent::actions();

        // Read-only until auth + ownership scoping is implemented.
        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
