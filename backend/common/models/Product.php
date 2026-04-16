<?php

namespace common\models;

use \common\models\BaseModel;

class Product extends BaseModel {
	public $product_id_list;

	public static function tableName() {
		return 'product';
	}
}
