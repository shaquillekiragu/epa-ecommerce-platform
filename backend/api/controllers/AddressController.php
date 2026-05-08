<?php

namespace api\controllers;

use api\models\Address;

class AddressController extends _ApiController
{
    public $modelClass = Address::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
