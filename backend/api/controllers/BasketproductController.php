<?php

namespace api\controllers;

use api\models\Basketproduct;

class BasketproductController extends _ApiController
{
    public $modelClass = Basketproduct::class;

    public function actions()
    {
        $actions = parent::actions();

        // Read-only until auth + ownership scoping is implemented.
        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
