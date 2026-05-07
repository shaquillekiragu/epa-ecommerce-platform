<?php

namespace common\models;

use Override;
use yii\db\ActiveQuery;
use yii\helpers\Inflector;
use common\models\BaseModel;

class Product extends BaseModel
{
    public static function tableName()
    {
        return '{{%product}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'store_id',
                        'product_category_id',
                        'number_in_stock',
                        'weight_in_grams',
                    ],
                    'integer'
                ],
                [
                    [
                        'price_in_gbp',
                    ],
                    'number'
                ],
                [['price_in_gbp'], 'compare', 'compareValue' => 0, 'operator' => '>='],
                [
                    [
                        'is_active',
                    ],
                    'boolean'
                ],
                [
                    [
                        'allow_update',
                        'allow_delete',
                    ],
                    'boolean'
                ],
                [
                    [
                        'name',
                        'thumbnail',
                        'seo_title',
                        'slug',
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    [
                        'sku_code',
                    ],
                    'string',
                    'length' => 64
                ],
                [
                    [
                        'store_id',
                        'name',
                        'product_category_id',
                        'price_in_gbp',
                        'number_in_stock',
                        'sku_code',
                        'weight_in_grams',
                        'thumbnail',
                        'is_active',
                        'allow_update',
                        'allow_delete',
                    ],
                    'required'
                ],
                [['number_in_stock', 'weight_in_grams'], 'compare', 'compareValue' => 0, 'operator' => '>='],
                [
                    [
                        'name'
                    ],
                    'unique'
                ],
            ]
        );
    }

    #[Override]
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        $name = trim((string)$this->name);
        $sku_code = trim((string)$this->sku_code);

        $this->seo_title = $name !== '' ? mb_substr($name, 0, 255) : null;

        $base = trim($name . ' ' . $sku_code);
        $this->slug = $base !== '' ? mb_substr(Inflector::slug($base), 0, 255) : null;

        return true;
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'store_id' => 'Store ID',
                'name' => 'Product Name',
                'slug' => 'Slug',
                'product_category_id' => 'Product Category ID',
                'productCategoryName' => 'Product Category',
                'description' => 'Description',
                'price_in_gbp' => 'Price (GBP)',
                'number_in_stock' => 'Stock Quantity',
                'sku_code' => 'SKU Code',
                'weight_in_grams' => 'Weight (g)',
                'thumbnail' => 'Thumbnail',
                'seo_title' => 'SEO Title',
                'is_active' => 'Is Active',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }

    public function getProductCategory(): ActiveQuery
    {
        return $this->hasOne(Productcategory::class, ['id' => 'product_category_id']);
    }

    public function getStore(): ActiveQuery
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }

    public function getProductCategoryName(): ?string
    {
        return $this->productCategory->name ?? null;
    }

    
}

// Model today: Pricing, stock, SKU, is_active, joins to store/category; beforeValidate always overwrites seo_title and slug from name + sku_code.

// Recommended business logic:

// Monetary: price_in_gbp ≥ 0, reasonable max; consider integer minor units later to avoid float issues (you already migrated some totals to float—products should follow the same convention).
// Stock: number_in_stock ≥ 0; optional reservation rules when you add checkout.
// SKU: Uniqueness—typically per store_id (or globally); enforce with composite unique index when you define the rule.
// Slug / SEO: If slugs must be stable for published URLs, regenerating on every validate can break bookmarks—consider immutable slug after first publish or redirects; if you keep current behavior, document that URLs change when name/SKU changes.
// Active catalog: Hide inactive products from storefront queries (API query layer).
// Store/category consistency: Optionally validate product_category is allowed for that store if you introduce such rules.

// Leave child models empty
