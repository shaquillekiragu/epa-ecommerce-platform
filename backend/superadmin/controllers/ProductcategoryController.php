<?php

namespace superadmin\controllers;

use superadmin\models\Productcategory;
use superadmin\models\filter\ProductcategoryFilter;

class ProductcategoryController extends DashboardController
{
    public $model_class = Productcategory::class;
    public $filter_model_class = ProductcategoryFilter::class;
}
