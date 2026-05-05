<?php

namespace api\controllers;

use api\models\User;

class UserController extends _ApiController
{
    public $modelClass = User::class;

    public function actions()
    {
        $actions = parent::actions();

        // Read-only until auth + ownership scoping is implemented.
        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
