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
                    'range' => ['shipping', 'billing', 'both']
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
                        'allow_update',
                        'allow_delete',
                    ],
                    'boolean'
                ],
                [
                    [
                        'address_type',
                        'building_number',
                        'street_name',
                        'city',
                        'country',
                        'post_code',
                        'allow_update',
                        'allow_delete',
                    ],
                    'required'
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'address_type' => 'Address Type',
                'building_number' => 'Building No.',
                'street_name' => 'Street Name',
                'city' => 'City',
                'region' => 'Region',
                'post_code' => 'Post Code',
                'country' => 'Country',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }

    public function getFullAddress()
    {
        if ($this->region){
            return "$this->building_number $this->street_name, $this->city, $this->region, $this->post_code, $this->country";
        }
        return "$this->building_number $this->street_name, $this->city, $this->post_code, $this->country";
    }
}
