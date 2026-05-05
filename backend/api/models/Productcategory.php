<?php

namespace api\models;

use common\models\Productcategory as CommonProductcategory;

class Productcategory extends CommonProductcategory
{
    public function fields()
    {
        return [
            'id',
            'category_name',
            'description',
            'thumbnail',
        ];
    }
}
