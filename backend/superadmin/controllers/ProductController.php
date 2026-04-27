<?php

namespace superadmin\controllers;

use superadmin\models\Product;
use superadmin\models\filter\ProductFilter;

class ProductController extends DashboardController
{
    public $model_class = Product::class;
    public $filter_model_class = ProductFilter::class;
}
