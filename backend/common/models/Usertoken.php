<?php

namespace common\models;

use yii\db\ActiveQuery;

class Usertoken extends BaseModel
{
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'user_id'
                ],
                'integer'
            ],
            [
                [
                    'token_hash'
                ],
                'string', 'max' => 255
            ],
            [
                [
                    'created_at',
                    'expires_at',
                    'revoked_at',
                    'last_used_at'
                ],
                'safe'
            ],
            [
                [
                    'user_id',
                    'token_hash'
                ],
                'required'
            ],
        ]);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getIsRevoked(): bool
    {
        return $this->revoked_at !== null;
    }

    public function getIsExpired(): bool
    {
        return $this->expires_at !== null && strtotime($this->expires_at) < time();
    }
}
