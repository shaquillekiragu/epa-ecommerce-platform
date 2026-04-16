<?php

namespace common\models;

use common\models\BaseModel;

class Basket extends BaseModel
{
    public $basket_id_list;

    public static function tableName()
    {
        return '{{%basket}}';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'customer_id',
                        'price_total',
                    ],
                    'integer'
                ],
                [
                    [
                        'customer_id',
                        'price_total',
                    ],
                    'required'
                ],
            ]
        );
    }
}
