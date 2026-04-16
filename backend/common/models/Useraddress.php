<?php

namespace common\models;

use common\models\BaseModel;

class Useraddress extends BaseModel
{
    public $user_address_id_list;

    public static function tableName()
    {
        return '{{%user_address}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'user_id',
                        'address_id',
                    ],
                    'integer'
                ],
                [
                    [
                        'user_id',
                        'address_id',
                    ],
                    'required'
                ],
                [
                    [
                        'user_id',
                        'address_id'
                    ],
                    'unique',
                    'targetAttribute' => ['user_id', 'address_id']
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'address_id' => 'Address ID',
        ];
    }
}
