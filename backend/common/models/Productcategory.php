<?php

namespace common\models;

use Override;
use yii\base\UserException;
use yii\db\ActiveQuery;
use common\validators\ThumbnailValidator;

class Productcategory extends BaseModel
{
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
                    'max' => 65535
                ],
                [['name', 'description'], 'trim'],
                [
                    ['name'],
                    'match',
                    'pattern' => '/[A-Za-z]/',
                    'message' => 'Category name must contain letters.'
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
                [
                    ['thumbnail'],
                    'trim',
                ],
                [
                    ['thumbnail'],
                    ThumbnailValidator::class,
                    'skipOnEmpty' => true,
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

    #[Override]
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->name !== null && $this->name !== '') {
            $name = preg_replace('/\s+/u', ' ', trim((string) $this->name));
            $this->name = $name;
        }

        if ($this->description !== null && $this->description !== '') {
            $this->description = trim((string) $this->description);
        }

        return true;
    }

    #[Override]
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->getProducts()->exists()) {
            throw new UserException(
                'Cannot delete this category while products still reference it. Reassign or remove those products first.'
            );
        }

        return true;
    }
}
