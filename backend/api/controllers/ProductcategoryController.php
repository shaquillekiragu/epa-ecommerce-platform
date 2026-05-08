<?php

namespace api\controllers;

use api\models\Productcategory;

class ProductcategoryController extends _ApiController
{
    public $modelClass = Productcategory::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }
}
