<?php

namespace superadmin\controllers;

use superadmin\models\Product;
use superadmin\models\search\ProductSearch;

class ProductController extends AdminPanelController
{
    public $model_class = Product::class;
    public $search_model_class = ProductSearch::class;
}
