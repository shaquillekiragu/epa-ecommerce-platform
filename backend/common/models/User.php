<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use common\models\BaseModel;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $hashed_password
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */

class User extends BaseModel
{
    // public const STATUS_DELETED = 0;
    // public const STATUS_INACTIVE = 9;
    // public const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%user}}';
    }

    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::class,
    //     ];
    // }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                // [
                //     [
                //         'status'
                //     ],
                //     'default',
                //     'value' => self::STATUS_INACTIVE
                // ],
                // [
                //     [
                //         'status'
                //     ],
                //     'in',
                //     'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]
                // ],
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
                    'range' => ['customer', 'merchant']
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
                    [
                        'mobile_number'
                    ],
                    'string',
                    'max' => 20
                ],
                [
                    [
                        'date_of_birth'
                    ],
                    'date'
                ],
                [
                    [
                        'is_account_active'
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
                        'deleted_at'
                    ],
                    'safe'
                ],
                [
                    [
                        'role',
                        'first_name',
                        'last_name',
                        'email',
                        'hashed_password',
                        'date_of_birth',
                        'country',
                        'mobile_number',
                        'is_account_active',
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
                'is_account_active' => 'Account Activity Status',
                'deleted_at' => 'Deleted At',
                'allow_update' => 'Allow Update',
                'allow_delete' => 'Allow Delete',
            ]
        );
    }

    // public static function findIdentity($id)
    // {
    //     return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    // }

    // public static function findIdentityByAccessToken($token, $type = null)
    // {
    //     throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    // }

    // public static function findByPasswordResetToken($token)
    // {
    //     if (!static::isPasswordResetTokenValid($token)) {
    //         return null;
    //     }

    //     return static::findOne([
    //         'password_reset_token' => $token,
    //         'status' => self::STATUS_ACTIVE,
    //     ]);
    // }

    // public static function findByVerificationToken($token)
    // {
    //     return static::findOne([
    //         'verification_token' => $token,
    //         'status' => self::STATUS_INACTIVE
    //     ]);
    // }

    // public static function isPasswordResetTokenValid($token)
    // {
    //     if (empty($token)) {
    //         return false;
    //     }

    //     $timestamp = (int) substr($token, strrpos($token, '_') + 1);
    //     $expire = Yii::$app->params['user.passwordResetTokenExpire'];
    //     return $timestamp + $expire >= time();
    // }

    // public function getId()
    // {
    //     return $this->getPrimaryKey();
    // }

    // public function getAuthKey()
    // {
    //     return $this->auth_key;
    // }

    // public function validateAuthKey($authKey)
    // {
    //     return $this->getAuthKey() === $authKey;
    // }

    // /**
    //  * Validates password
    //  *
    //  * @param string $password password to validate
    //  * @return bool if password provided is valid for current user
    //  */
    // public function validatePassword($password)
    // {
    //     return Yii::$app->security->validatePassword($password, $this->hashed_password);
    // }

    // /**
    //  * Generates password hash from password and sets it to the model
    //  *
    //  * @param string $password
    //  */
    // public function setPassword($password)
    // {
    //     $this->hashed_password = Yii::$app->security->generatePasswordHash($password);
    // }

    // /**
    //  * Generates "remember me" authentication key
    //  */
    // public function generateAuthKey()
    // {
    //     $this->auth_key = Yii::$app->security->generateRandomString();
    // }

    // /**
    //  * Generates new password reset token
    //  */
    // public function generatePasswordResetToken()
    // {
    //     $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    // }

    // /**
    //  * Generates new token for email verification
    //  */
    // public function generateEmailVerificationToken()
    // {
    //     $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    // }

    // /**
    //  * Removes password reset token
    //  */
    // public function removePasswordResetToken()
    // {
    //     $this->password_reset_token = null;
    // }

    public function getFullName()
    {
        if ($this->middle_names){
            return "$this->first_name $this->middle_names $this->last_name";
        }
        return "$this->first_name $this->last_name";
    }

    public function getUserAge()
    {
        return (new \DateTime($this->date_of_birth))->diff(new \DateTime('today'))->y;
    }
}
