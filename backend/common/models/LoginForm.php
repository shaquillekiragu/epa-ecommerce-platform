<?php

namespace common\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    public bool $remember_me = true;

    private ?User $_user = null;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['remember_me', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail((string)$this->email);
        }

        return $this->_user;
    }
}
