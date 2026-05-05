<?php

namespace api\controllers;

use api\models\User;

class UserController extends _ApiController
{
    public $modelClass = User::class;
}
