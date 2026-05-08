<?php

namespace api\controllers;

use api\models\Basket;

class BasketController extends _ApiController
{
    public $modelClass = Basket::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
