<?php

namespace api\models;

use Yii;
use common\models\User as CommonUser;

class User extends CommonUser
{
    public function fields()
    {
        $viewer_id = null;

        try {
            $viewer_id = Yii::$app->user && !Yii::$app->user->isGuest ? (int)Yii::$app->user->id : null;
        } catch (\Throwable) {
            $viewer_id = null;
        }

        $is_self = $viewer_id !== null && (int)$this->id === (int)$viewer_id;

        $fields = [
            'id',
            'first_name',
            'last_name',
            'full_name' => static fn (self $model) => $model->fullName,
        ];

        if ($is_self) {
            $fields = array_merge($fields, [
                'role',
                'middle_names',
                'email',
                'date_of_birth',
                'user_age' => static fn (self $model) => $model->userAge,
                'country',
                'mobile_number',
                'is_active',
                'deactivated_at',
            ]);
        }

        return $fields;
    }
}
