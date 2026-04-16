<?php

namespace common\models;

use \common\models\BaseModel;

class Basket extends BaseModel {
	public $basket_id_list;

	public static function tableName() {
		return 'basket';
	}
}
