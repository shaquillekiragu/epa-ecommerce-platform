<?php

namespace common\models;

use common\models\BaseModel;

class Useraddress extends BaseModel
{
    public $user_address_id_list;

    public static function tableName()
    {
        return 'user_address';
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
                        'user_id',
                        'address_id',
                        'created_by',
                        'last_updated_by',
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
}
