<?php

namespace superadmin\controllers;

use superadmin\models\User;
use superadmin\models\search\UserSearch;

class UserController extends AdminPanelController
{
    public $model_class = User::class;
    public $search_model_class = UserSearch::class;
}
