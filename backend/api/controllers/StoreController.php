<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;
use api\models\Store;

class StoreController extends _ApiController
{
    public $modelClass = Store::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider(IndexAction $action, $filter = null): ActiveDataProvider
    {
        $query = Store::find();

        Store::applyListFilters($query, \Yii::$app->request->getQueryParams());

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [1, 100],
                'defaultPageSize' => 24,
            ],
        ]);
    }
}
