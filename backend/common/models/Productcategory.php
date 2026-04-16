<?php

namespace common\models;

use common\models\BaseModel;

class Productcategory extends BaseModel
{
    public $product_category_id_list;

    public static function tableName()
    {
        return 'product_category';
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
                        'created_by',
                        'last_updated_by',
                    ],
                    'integer'
                ],
                [
                    [
                        'created_at',
                        'last_updated_at',
                    ],
                    'safe'
                ],
                [
                    [
                        'category_name',
                        'description',
                        'created_by',
                        'last_updated_by',
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
}
