<?php

namespace common\models;

use common\models\BaseModel;
use yii\base\InvalidCallException;

class Address extends BaseModel
{
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
                    ['post_code'],
                    'match',
                    'pattern' => '/^[A-Za-z0-9](?:[A-Za-z0-9 \\-]{0,18}[A-Za-z0-9])?$/',
                    'message' => 'Post Code must contain only letters, numbers, spaces, or hyphens.',
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

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->post_code !== null) {
            $this->post_code = strtoupper(trim((string)$this->post_code));
        }

        if ($this->country !== null) {
            $this->country = trim((string)$this->country);
        }

        return true;
    }

    public function beforeSave($insert)
    {
        if (!$insert && $this->getUserAddresses()->exists()) {
            throw new InvalidCallException('This address is already linked and cannot be modified. Create a new address instead.');
        }

        return parent::beforeSave($insert);
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

    public function getUserAddresses()
    {
        return $this->hasMany(Useraddress::class, ['address_id' => 'id']);
    }
}
