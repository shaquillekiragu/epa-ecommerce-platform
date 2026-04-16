<?php

namespace common\models;

use \common\models\BaseModel;

class Orderproduct extends BaseModel {
	public $order_product_id_list;

	public static function tableName() {
		return 'order_product';
	}
}
