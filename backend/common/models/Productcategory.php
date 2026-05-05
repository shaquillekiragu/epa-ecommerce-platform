<?php

namespace common\models;

use yii\db\ActiveQuery;
use common\models\BaseModel;

class Productcategory extends BaseModel
{
    public $product_category_id_list;

    public static function tableName()
    {
        return '{{%product_category}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'name',
                        'description',
                        'thumbnail',
                    ],
                    'string',
                    'max' => 255
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
                        'description',
                        'allow_update',
                        'allow_delete',
                    ],
                    'required'
                ],
                [
                    [
                        'name'
                    ],
                    'unique'
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'name' => 'Category Name',
                'description' => 'Description',
                'thumbnail' => 'Thumbnail',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['product_category_id' => 'id']);
    }
}

// Model today: name, description, thumbnail; name globally unique; allow_* flags.

// Recommended business logic:

// Naming: Trim/normalize name; decide uniqueness global vs per-store if categories become store-scoped.
// Thumbnail: Validate URL or storage key if uploads are added.
// Deletes: Deleting/deactivating categories must account for products still referencing them (restrict, cascade, or archive).

// Leave child models empty — use superadmin\models\Productcategory / api\models\Productcategory for read vs write scenarios.
