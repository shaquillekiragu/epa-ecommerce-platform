<?php

namespace common\models;

use Override;
use yii\db\ActiveQuery;
use yii\base\UserException;

class Store extends BaseModel
{
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
                        'name',
                        'description'
                    ],
                    'trim'
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
                        'merchant_id'
                    ],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => User::class,
                    'targetAttribute' => ['merchant_id' => 'id'],
                ],
                [
                    [
                        'merchant_id'
                    ],
                    'validateMerchantRole',
                ],
                [
                    [
                        'merchant_id',
                        'name'
                    ],
                    'unique',
                    'targetAttribute' => ['merchant_id', 'name'],
                    'message' => 'You already have a store with this name.',
                ],
            ]
        );
    }

    public function validateMerchantRole(string $attribute): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = User::findOne((int) $this->$attribute);
        
        if ($user === null) {
            return;
        }

        if ($user->role !== 'merchant') {
            $this->addError($attribute, 'Merchant ID must reference a user with the merchant role.');
        }
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

    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['store_id' => 'id']);
    }

    public function getMerchant(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'merchant_id']);
    }

    #[Override]
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->name !== null && $this->name !== '') {
            $this->name = preg_replace('/\s+/u', ' ', trim((string) $this->name));
        }

        if ($this->description !== null && $this->description !== '') {
            $this->description = trim((string) $this->description);
        }

        return true;
    }

    #[Override]
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->getProducts()->exists()) {
            throw new UserException(
                'Cannot delete this store while products still reference it. Remove or reassign those products first.'
            );
        }

        if ($this->getOrders()->exists()) {
            throw new UserException(
                'Cannot delete this store while orders still reference it.'
            );
        }

        return true;
    }
}
