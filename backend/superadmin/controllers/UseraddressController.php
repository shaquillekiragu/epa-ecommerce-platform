<?php

namespace superadmin\controllers;

use superadmin\models\Useraddress;
use superadmin\models\search\UseraddressSearch;

class UseraddressController extends AdminPanelController
{
    public $model_class = Useraddress::class;
    public $search_model_class = UseraddressSearch::class;
}
