<?php

namespace api\controllers;

use api\models\Product;

class ProductController extends _ApiController
{
    public $modelClass = Product::class;
}
