<?php

namespace common\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'id',
                        'created_by',
                        'last_updated_by'
                    ],
                    'integer'
                ],
                [
                    [
                        'created_at',
                        'last_updated_at'
                    ],
                    'safe'
                ],
            ]
        );
    }

    // attributes
    // search functionality - for relevant models
    // beforeSave - set created_at only on creation - set created_by using logged-in user - look at docs - look at types
}
