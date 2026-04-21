<?php

namespace superadmin\controllers;

use superadmin\models\Address;
use superadmin\models\search\AddressSearch;

class AddressController extends CrudController
{
    public $model_class = Address::class;
    public $search_model_class = AddressSearch::class;
}
