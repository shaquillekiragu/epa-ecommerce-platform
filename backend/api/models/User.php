<?php

namespace api\models;

use common\models\User as CommonUser;

class User extends CommonUser
{
    public function fields()
    {
        return [
            'id',
            'role',
            'first_name',
            'middle_names',
            'last_name',
            'full_name' => static fn (self $model) => $model->fullName,
            'email',
            'date_of_birth',
            'user_age' => static fn (self $model) => $model->userAge,
            'country',
            'mobile_number',
            'is_active',
            'deactivated_at',
            'allow_update',
            'allow_delete',
            'created_at',
            'last_updated_at',
        ];
    }
}
