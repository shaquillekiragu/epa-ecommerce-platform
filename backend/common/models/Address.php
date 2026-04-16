<?php

namespace common\models;

use common\models\BaseModel;

class Address extends BaseModel
{
    public $address_id_list;

    public static function tableName()
    {
        return '{{%address}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'address_type',
                    ],
                    'in',
                    'range' => ['shipping', 'billing']
                ],
                [
                    [
                        'building_number',
                        'street_name',
                        'city',
                        'region',
                        'country',
                        'post_code',
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    [
                        'address_type',
                        'building_number',
                        'street_name',
                        'city',
                        'country',
                        'post_code',
                    ],
                    'required'
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return [
            'address_type' => 'Address Type',
            'building_number' => 'Building No.',
            'street_name' => 'Street Name',
            'city' => 'City',
            'region' => 'Region',
            'country' => 'Country',
            'post_code' => 'Post Code',
        ];
    }
}
