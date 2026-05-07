<?php

namespace api\controllers;

use api\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class ProductController extends _ApiController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }

    public function prepareDataProvider()
    {
        $query = Product::find()->andWhere(['is_active' => 1]);

        $category = \Yii::$app->request->get('category');
        if ($category !== null && $category !== '') {
            $query->andWhere(['product_category_id' => (int) $category]);
        }

        $search = \Yii::$app->request->get('search');
        if ($search !== null && trim((string) $search) !== '') {
            $query->andWhere(['like', 'product_name', trim((string) $search)]);
        }

        $sort = (string) \Yii::$app->request->get('sort', '');
        if ($sort !== '') {
            $direction = SORT_ASC;
            $field = $sort;
            if (str_starts_with($sort, '-')) {
                $direction = SORT_DESC;
                $field = substr($sort, 1);
            }

            $allowed = [
                'price_in_gbp' => 'price_in_gbp',
                'product_name' => 'product_name',
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
