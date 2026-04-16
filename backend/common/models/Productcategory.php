<?php

namespace common\models;

use \common\models\BaseModel;

class Productcategory extends BaseModel {
	public $product_category_id_list;

	public static function tableName() {
		return 'product_category';
	}
}
