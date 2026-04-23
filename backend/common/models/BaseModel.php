<?php

namespace common\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public function rules()
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

    // beforeSave - set created_at only on creation - set created_by using logged-in user - look at docs - look at types
}
