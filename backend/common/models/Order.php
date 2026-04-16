<?php

namespace common\models;

use \common\models\BaseModel;

class Order extends BaseModel {
	public $order_id_list;

	public static function tableName() {
		return 'order';
	}
}
