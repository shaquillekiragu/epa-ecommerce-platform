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
                        'name',
                        'description',
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
                        'name',
                        'description',
                        'merchant_id',
                        'allow_update',
                        'allow_delete',
                    ],
                    'required'
                ],
                [
                    [
                        'name'
                    ],
                    'unique'
                ],
                [
                    [
                        'description'
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
                'name' => 'Store Name',
                'description' => 'Store Description',
                'merchant_id' => 'Merchant ID',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }
}

// Model today: merchant_id, name unique, description also unique (unusual for a description).

// Recommended business logic:

// Ownership: merchant_id should reference a user with role merchant (FK ensures row exists, not role).
// Uniqueness: Prefer unique (merchant_id, name) over global unique description; align rules + migration when ready.
// Authorization: Only owning merchant or superadmin may update; enforce in controllers/services + RBAC.

// Leave child models empty — use api\models\Store / superadmin\models\Store for scenario-based mass-assignment if merchant vs admin differ.
