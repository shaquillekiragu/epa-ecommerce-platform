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
                        'allow_update',
                        'allow_delete',
                    ],
                    'boolean'
                ],
                [
                    [
                        'store_name',
                        'store_description',
                        'merchant_id',
                        'allow_update',
                        'allow_delete',
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
        return array_merge(
            parent::attributeLabels(),
            [
                'store_name' => 'Store Name',
                'store_description' => 'Store Description',
                'merchant_id' => 'Merchant ID',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }
}

// Model today: merchant_id, store_name unique, store_description also unique (unusual for a description).

// Recommended business logic:

// Ownership: merchant_id should reference a user with role merchant (FK ensures row exists, not role).
// Uniqueness: Prefer unique (merchant_id, store_name) over global unique store_description; align rules + migration when ready.
// Authorization: Only owning merchant or superadmin may update; enforce in controllers/services + RBAC.

// Leave child models empty — use api\models\Store / superadmin\models\Store for scenario-based mass-assignment if merchant vs admin differ.
