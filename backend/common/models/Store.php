<?php

namespace common\models;

use yii\db\ActiveQuery;
use common\models\BaseModel;
use common\models\Product;
use common\models\User;

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

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['store_id' => 'id']);
    }

    public function getMerchant(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'merchant_id']);
    }
}

// Model today: merchant_id; name globally unique; description is not unique.

// Recommended business logic:

// Ownership: merchant_id should reference a user with role merchant (FK ensures row exists, not role).
// Uniqueness: Consider composite unique (merchant_id, name) instead of global unique name when multi-tenant rules firm up.
// Authorization: Only owning merchant or superadmin may update; enforce in controllers/services + RBAC.

// Leave child models empty — use api\models\Store / superadmin\models\Store for scenario-based mass-assignment if merchant vs admin differ.
