<?php

namespace api\models;

use common\models\Address as CommonAddress;

class Address extends CommonAddress
{
    public function fields()
    {
        return [
            'id',
            'address_type',
            'building_number',
            'street_name',
            'city',
            'region',
            'post_code',
            'country',
            'full_address' => static fn (self $model) => $model->fullAddress,
            'allow_update',
            'allow_delete',
            'created_at',
            'last_updated_at',
        ];
    }
}
