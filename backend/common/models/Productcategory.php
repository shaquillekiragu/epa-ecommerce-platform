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
                        'category_name',
                        'description',
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
        return [
            'category_name' => 'Category Name',
            'description' => 'Description',
            'thumbnail' => 'Thumbnail',
        ];
    }
}
