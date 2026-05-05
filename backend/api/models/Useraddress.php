<?php

namespace api\models;

use common\models\Useraddress as CommonUseraddress;

class Useraddress extends CommonUseraddress
{
    public function fields()
    {
        return [
            'id',
            'user_id',
            'address_id',
            'allow_update',
            'allow_delete',
            'created_at',
            'last_updated_at',
        ];
    }
}
