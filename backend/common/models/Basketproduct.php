<?php

namespace common\models;

use \common\models\BaseModel;

class Basketproduct extends BaseModel {
	public $basket_product_id_list;

	public static function tableName() {
		return 'basket_product';
	}
}
