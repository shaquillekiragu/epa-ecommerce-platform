<?php

namespace api\models;

use yii\db\ActiveQuery;
use common\models\Product as CommonProduct;
use common\models\Productcategory;
use common\models\Store as CommonStore;

class Product extends CommonProduct
{
    public function fields()
    {
        return [
            'id',
            'store_id',
            'store_name' => static fn (self $model) => $model->storeName,
            'name',
            'slug',
            'product_category_id',
            'product_category_name' => static fn (self $model) => $model->productCategoryName,
            'description',
            'price_in_gbp',
            'number_in_stock',
            'sku_code',
            'weight_in_grams',
            'thumbnail',
            'seo_title',
            'is_active',
        ];
    }

    /**
     * Catalogue list filters from query string params (frontend / public API).
     *
     * Supported keys:
     * - `category` or `product_category_id` — exact category id
     * - `store_id` — exact store id
     * - `search` — substring match on product name or SKU
     * - `product_category_name` — substring match on related category name
     * - `store_name` — substring match on related store name
     * - `slug` — exact match on product slug (detail pages)
     * - `categories` — comma-separated category ids (OR); takes precedence over `category` when non-empty
     * - `price_min` / `price_max` — inclusive bounds on `price_in_gbp` (numeric)
     * - `stock` — `in` (stock &gt; 0) or `out` (stock &lt;= 0); omit for all
     *
     * @param array<string, mixed> $params
     */
    public static function applyListFilters(ActiveQuery $query, array $params): void
    {
        $t = static::tableName();

        $slug = trim((string) ($params['slug'] ?? ''));
        if ($slug !== '') {
            $query->andWhere([$t . '.slug' => $slug]);
        }

        $categoriesCsv = trim((string) ($params['categories'] ?? ''));
        if ($categoriesCsv !== '') {
            $ids = array_values(array_filter(
                array_map(static fn (string $v): int => (int) trim($v), explode(',', $categoriesCsv)),
                static fn (int $id): bool => $id > 0
            ));
            if (count($ids) > 0) {
                $query->andWhere(['in', $t . '.product_category_id', $ids]);
            }
        } else {
            $categoryId = $params['category'] ?? $params['product_category_id'] ?? null;
            if ($categoryId !== null && $categoryId !== '' && (int) $categoryId > 0) {
                $query->andWhere([$t . '.product_category_id' => (int) $categoryId]);
            }
        }

        if (($storeId = $params['store_id'] ?? null) !== null && $storeId !== '' && (int) $storeId > 0) {
            $query->andWhere([$t . '.store_id' => (int) $storeId]);
        }

        $search = trim((string) ($params['search'] ?? ''));
        if ($search !== '') {
            $query->andWhere([
                'or',
                ['like', $t . '.name', $search],
                ['like', $t . '.sku_code', $search],
            ]);
        }

        $productCategoryName = trim((string) ($params['product_category_name'] ?? ''));
        if ($productCategoryName !== '') {
            $query->joinWith(['productCategory'])
                ->andWhere(['like', Productcategory::tableName() . '.name', $productCategoryName]);
        }

        $storeName = trim((string) ($params['store_name'] ?? ''));
        if ($storeName !== '') {
            $query->joinWith(['store'])
                ->andWhere(['like', CommonStore::tableName() . '.name', $storeName]);
        }

        $priceMin = $params['price_min'] ?? $params['min_price'] ?? null;
        if ($priceMin !== null && $priceMin !== '' && is_numeric($priceMin)) {
            $query->andWhere(['>=', $t . '.price_in_gbp', (float) $priceMin]);
        }

        $priceMax = $params['price_max'] ?? $params['max_price'] ?? null;
        if ($priceMax !== null && $priceMax !== '' && is_numeric($priceMax)) {
            $query->andWhere(['<=', $t . '.price_in_gbp', (float) $priceMax]);
        }

        $stock = trim((string) ($params['stock'] ?? ''));
        if ($stock === 'in') {
            $query->andWhere(['>', $t . '.number_in_stock', 0]);
        } elseif ($stock === 'out') {
            $query->andWhere(['<=', $t . '.number_in_stock', 0]);
        }
    }
}
