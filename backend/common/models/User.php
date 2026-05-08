<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use common\models\BaseModel;
use common\models\Useraddress;

class User extends BaseModel implements IdentityInterface
{
    public ?string $password = null;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'role'
                    ],
                    'default',
                    'value' => 'customer'
                ],
                [
                    [
                        'role'
                    ],
                    'in',
                    'range' => ['customer', 'merchant', 'superadmin']
                ],
                [
                    [
                        'first_name',
                        'middle_names',
                        'last_name',
                        'email',
                        'hashed_password',
                        'country',
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    ['password'],
                    'string',
                    'min' => 8,
                    'max' => 255,
                ],
                [
                    ['password'],
                    'match',
                    'pattern' => '/^(?=.*[A-Za-z])(?=.*\d).+$/',
                    'message' => 'Password must contain at least one letter and one number.',
                ],
                [
                    [
                        'mobile_number'
                    ],
                    'string',
                    'max' => 20
                ],
                [
                    ['email'],
                    'email',
                ],
                [
                    [
                        'date_of_birth'
                    ],
                    'date',
                    'format' => 'php:Y-m-d',
                ],
                [
                    [
                        'is_active'
                    ],
                    'boolean'
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
                        'deactivated_at'
                    ],
                    'safe'
                ],
                [
                    [
                        'role',
                        'first_name',
                        'last_name',
                        'email',
                        'date_of_birth',
                        'country',
                        'mobile_number',
                        'is_active',
                        'allow_update',
                        'allow_delete',
                    ],
                    'required'
                ],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'role' => 'User Role',
                'first_name' => 'First Name',
                'middle_names' => 'Middle Name(s)',
                'last_name' => 'Last Name',
                'email' => 'Email',
                'hashed_password' => 'Password',
                'date_of_birth' => 'Date of Birth',
                'country' => 'Country',
                'mobile_number' => 'Mobile Number',
                'is_active' => 'Active Status',
                'deactivated_at' => 'Deactivated At',
                'allow_update' => 'Allow Updates',
                'allow_delete' => 'Allow Deletion',
            ]
        );
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented. Use API bearer tokens.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($auth_key)
    {
        return false;
    }

    public static function findByEmail(string $email): ?self
    {
        $email = mb_strtolower(trim($email));
        $user = static::findOne(['email' => $email]);
        return $user;
    }

    public function validatePassword(string $password): bool
    {
        $hash = (string) ($this->hashed_password ?? '');

        if ($hash === '') {
            return false;
        }

        return Yii::$app->security->validatePassword($password, $hash);
    }

    public function setPassword(string $password): void
    {
        $this->hashed_password = Yii::$app->security->generatePasswordHash($password);
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->email !== null) {
            $this->email = mb_strtolower(trim((string)$this->email));
        }

        return true;
    }

    public function beforeSave($insert)
    {
        if ($this->password !== null && $this->password !== '') {
            $this->setPassword($this->password);
        }

        if ($this->hasAttribute('is_active') && $this->hasAttribute('deactivated_at')) {
            if ($this->is_active) {
                $this->deactivated_at = null;
            } elseif ($this->deactivated_at === null) {
                $this->deactivated_at = date('Y-m-d H:i:s');
            }
        }

        return parent::beforeSave($insert);
    }

    public function getFullName()
    {
        if ($this->middle_names){
            return "$this->first_name $this->middle_names $this->last_name";
        }
        return "$this->first_name $this->last_name";
    }

    public function getUserAge(): ?int
    {
        try {
            $dob = (string)($this->date_of_birth ?? '');
            if ($dob === '') {
                return null;
            }

            return (new \DateTime($dob))->diff(new \DateTime('today'))->y;
        } catch (\Throwable) {
            return null;
        }
    }

    public function getUserAddresses()
    {
        return $this->hasMany(Useraddress::class, ['user_id' => 'id']);
    }

    public function getBillingAddress()
    {
        return $this->hasOne(Address::class, ['id' => 'address_id'])->via('userAddresses')->andWhere(['address_type' => ['billing', 'both']]);
    }

    public function getShippingAddress()
    {
        return $this->hasOne(Address::class, ['id' => 'address_id'])->via('userAddresses')->andWhere(['address_type' => ['shipping', 'both']]);
    }
}
