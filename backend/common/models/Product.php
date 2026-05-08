<?php

namespace common\models;

use Override;
use yii\db\ActiveQuery;
use yii\helpers\Inflector;

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
                    ['price_in_gbp'],
                    'compare',
                    'compareValue' => 1000000,
                    'operator' => '<=',
                    'message' => 'Price exceeds allowed maximum.'
                ],
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
                    'max' => 65535
                ],
                [['name', 'sku_code'], 'trim'],
                [
                    ['name'],
                    'match',
                    'pattern' => '/[A-Za-z]/',
                    'message' => 'Product name must contain letters.'
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
                    ['store_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Store::class,
                    'targetAttribute' => ['store_id' => 'id']
                ],
                [
                    ['product_category_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Productcategory::class,
                    'targetAttribute' => ['product_category_id' => 'id']
                ],
                [
                    ['store_id', 'sku_code'],
                    'unique',
                    'targetAttribute' => ['store_id', 'sku_code'],
                    'message' => 'SKU must be unique within this store.',
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

        $this->seo_title = mb_substr(($name !== '' ? $name : $sku_code), 0, 255);

        $regenerateSlug = true;
        if (!$this->isNewRecord && (bool) $this->getOldAttribute('is_active')) {
            $regenerateSlug = false;
        }

        if ($regenerateSlug) {
            $name_slug = Inflector::slug($name);
            $base = $name_slug !== '' ? ($name_slug . '-' . $sku_code) : $sku_code;
            $this->slug = mb_substr($base, 0, 255);
        }

        return true;
    }

    public static function activeCatalogQuery(): ActiveQuery
    {
        return static::find()->andWhere(['is_active' => true]);
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

    public function getProductCategoryName(): string
    {
        return $this->productCategory->name;
    }
}
