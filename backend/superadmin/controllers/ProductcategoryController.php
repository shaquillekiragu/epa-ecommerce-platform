<?php

namespace superadmin\controllers;

use superadmin\models\Productcategory;
use superadmin\models\search\ProductcategorySearch;

class ProductcategoryController extends DashboardController
{
    public $model_class = Productcategory::class;
    public $search_model_class = ProductcategorySearch::class;
}
