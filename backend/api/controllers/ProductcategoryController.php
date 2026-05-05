<?php

namespace api\controllers;

use api\models\Productcategory;

class ProductcategoryController extends _ApiController
{
    public $modelClass = Productcategory::class;

    public function actions()
    {
        $actions = parent::actions();

        // Public product endpoints: read-only.
        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
