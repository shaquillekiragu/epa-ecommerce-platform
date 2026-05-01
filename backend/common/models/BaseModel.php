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

// Model today: Shared audit attributes (id, created_*, last_updated_*); type rules only; beforeSave audit behaviour still TODO in comment.

// Recommended business logic:

// Audit: On insert set created_by / last_updated_by from current identity when unset; on update refresh last_updated_by. Align bootstrap user nullable created_by with other tables that require non-null FKs.
// allow_update / allow_delete: Enforce in beforeSave/beforeDelete (or a helper) so flagged records cannot be mutated in normal flows; superadmin bypass via explicit policy elsewhere.
// Lifecycle: One consistent rule for soft delete vs hard delete (e.g. user is_active + deactivated_at vs physical delete).

// N/A — base class only; no api/superadmin child models.
