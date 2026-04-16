<?php

namespace common\models;

use \common\models\BaseModel;

class Useraddress extends BaseModel {
	public $user_address_id_list;

	public static function tableName() {
		return 'user_address';
	}
}
