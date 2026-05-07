<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\base\InvalidCallException;
use common\models\BaseModel;

class Useraddress extends BaseModel
{
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
    
        public function beforeSave($insert)
        {
            if (!$insert) {
                $original_user_id = $this->getOldAttribute('user_id');
                
                if ($original_user_id !== null && (int)$this->user_id !== (int)$original_user_id) {
                    throw new InvalidCallException('Cannot change user_id for an existing user_address row. Delete and recreate the link instead.');
                }
            }
    
            return parent::beforeSave($insert);
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
