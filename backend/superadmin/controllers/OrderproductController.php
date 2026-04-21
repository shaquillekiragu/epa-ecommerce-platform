<?php

namespace superadmin\controllers;

use superadmin\models\Orderproduct;
use superadmin\models\search\OrderproductSearch;

class OrderproductController extends CrudController
{
    public $model_class = Orderproduct::class;
    public $search_model_class = OrderproductSearch::class;
}
