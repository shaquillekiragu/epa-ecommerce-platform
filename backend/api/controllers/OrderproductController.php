<?php

namespace api\controllers;

use api\models\Orderproduct;

class OrderproductController extends _ApiController
{
    public $modelClass = Orderproduct::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
