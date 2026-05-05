<?php

namespace api\controllers;

use api\models\Useraddress;

class UseraddressController extends _ApiController
{
    public $modelClass = Useraddress::class;

    public function actions()
    {
        $actions = parent::actions();

        // Read-only until auth + ownership scoping is implemented.
        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
