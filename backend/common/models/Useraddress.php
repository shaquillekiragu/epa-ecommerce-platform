<?php

namespace common\models;

use yii\db\ActiveQuery;
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
        return array_merge(
            parent::attributeLabels(),
            [
                'user_id' => 'User ID',
                'address_id' => 'Address ID',
            ]
        );
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getAddress(): ActiveQuery
    {
        return $this->hasOne(Address::class, ['id' => 'address_id']);
    }
}

// Model today: Join user_id ↔ address_id; unique (user_id, address_id).

// Recommended business logic:

// Ownership: Ensure address is not linked in conflicting ways without rules (e.g. shared address rows).
// Default address: If you add default shipping, enforce one-per-user in app logic (not in current schema).
// Cascade: Define behaviour on user delete (orphan addresses vs cascade).

// Leave child models empty — use api\models\Useraddress / superadmin\models\Useraddress for scenario splits.
