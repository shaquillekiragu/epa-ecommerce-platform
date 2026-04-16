<?php

namespace common\models;

use common\models\BaseModel;

class Store extends BaseModel
{
    public $store_id_list;

    public static function tableName()
    {
        return '{{%store}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'store_name',
                        'store_description',
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    [
                        'merchant_id',
                    ],
                    'integer'
                ],
                [
                    [
                        'store_name',
                        'store_description',
                        'merchant_id',
                    ],
                    'required'
                ],
                [
                    [
                        'store_name'
                    ],
                    'unique'
                ],
                [
                    [
                        'store_description'
                    ],
                    'unique'
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return [
            'store_name' => 'Store Name',
            'store_description' => 'Store Description',
            'merchant_id' => 'Merchant ID',
        ];
    }
}
