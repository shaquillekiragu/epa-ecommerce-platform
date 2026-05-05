<?php

namespace api\controllers;

use api\models\Product;

class ProductController extends _ApiController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();

        // Public product endpoints: read-only.
        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
