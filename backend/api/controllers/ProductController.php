<?php

namespace api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;
use yii\web\BadRequestHttpException;
use api\models\Product;

class ProductController extends _ApiController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        /** @see IndexAction::$prepareDataProvider — without this, list filters are never applied. */
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * @param mixed $filter built by {@see IndexAction::$dataFilter} when configured; unused here.
     */
    public function prepareDataProvider(IndexAction $action, $filter = null): ActiveDataProvider
    {
        $query = Product::activeCatalogQuery();

        Product::applyListFilters($query, \Yii::$app->request->getQueryParams());

        $sort = (string) (\Yii::$app->request->getQueryParams()['sort'] ?? '');
        if ($sort !== '') {
            $direction = SORT_ASC;
            $field = $sort;
            if (str_starts_with($sort, '-')) {
                $direction = SORT_DESC;
                $field = substr($sort, 1);
            }

            $allowed = [
                'price_in_gbp' => 'price_in_gbp',
                'name' => 'name',
                'number_in_stock' => 'number_in_stock',
                'created_at' => 'created_at',
            ];

            if (!isset($allowed[$field])) {
                throw new BadRequestHttpException('Invalid sort field.');
            }

            $query->orderBy([$allowed[$field] => $direction]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [1, 100],
                'defaultPageSize' => 24,
            ],
        ]);
    }
}
