<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;
use api\models\Store;

class StoreController extends _ApiController
{
    public $modelClass = Store::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }

    public function prepareDataProvider()
    {
        $query = Store::find();

        Store::applyListFilters($query, \Yii::$app->request->get());

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [1, 100],
                'defaultPageSize' => 24,
            ],
        ]);
    }
}
