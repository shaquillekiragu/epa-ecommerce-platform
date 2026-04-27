<?php

namespace common\models;

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
                        'category_name',
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
                        'category_name',
                        'description',
                        'allow_update',
                        'allow_delete',
                    ],
                    'required'
                ],
                [
                    [
                        'category_name'
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
                'category_name' => 'Category Name',
                'description' => 'Description',
                'thumbnail' => 'Thumbnail',
                'allow_update' => 'Allow Update',
                'allow_delete' => 'Allow Delete',
            ]
        );
    }
}
