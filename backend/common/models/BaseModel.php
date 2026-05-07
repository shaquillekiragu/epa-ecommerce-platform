<?php

namespace common\models;

use Yii;
use yii\base\InvalidCallException;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public function rules()
    {
        $integer_attrs = ['id'];
        if ($this->hasAttribute('created_by')) {
            $integer_attrs[] = 'created_by';
        }
        if ($this->hasAttribute('last_updated_by')) {
            $integer_attrs[] = 'last_updated_by';
        }

        $safe_attrs = [];
        if ($this->hasAttribute('created_at')) {
            $safe_attrs[] = 'created_at';
        }
        if ($this->hasAttribute('last_updated_at')) {
            $safe_attrs[] = 'last_updated_at';
        }

        $rules = parent::rules();
        if (!empty($integer_attrs)) {
            $rules[] = [$integer_attrs, 'integer'];
        }
        if (!empty($safe_attrs)) {
            $rules[] = [$safe_attrs, 'safe'];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'last_updated_by' => 'Last Updated By',
            'last_updated_at' => 'Last Updated At',
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        foreach ($this->attributes as $attribute => $value) {
            if (!is_string($value)) {
                continue;
            }
            $this->$attribute = trim($value);
        }

        return true;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!$insert && $this->hasAttribute('allow_update') && $this->allow_update === false) {
            throw new InvalidCallException('Updating is not allowed for this record.');
        }

        try {
            $user = Yii::$app->user ?? null;
            $identity = $user && !$user->isGuest ? $user->identity : null;
            $user_id = $identity?->getId();
        } catch (\Throwable) {
            $user_id = null;
        }

        if ($user_id !== null) {
            if ($insert && $this->hasAttribute('created_by') && ($this->created_by === null || $this->created_by === '')) {
                $this->created_by = (int)$user_id;
            }
            
            if ($this->hasAttribute('last_updated_by')) {
                $this->last_updated_by = (int)$user_id;
            }
        }

        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->hasAttribute('allow_delete') && $this->allow_delete === false) {
            throw new InvalidCallException('Deletion is not allowed for this record.');
        }

        return true;
    }
}
