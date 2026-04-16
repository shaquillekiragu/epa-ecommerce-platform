<?php

namespace common\models;

use \common\models\BaseModel;

class Store extends BaseModel {
	public $store_id_list;

	public static function tableName() {
		return 'store';
	}
}
