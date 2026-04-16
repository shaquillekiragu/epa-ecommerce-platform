<?php

namespace common\models;

use \common\models\BaseModel;

class Basket extends BaseModel {
	public $basket_id_list;

	public static function tableName() {
		return 'basket';
	}

	public function rules() {
		return array_merge(
			parent::rules(), [
				[
					[
						'customer_id',
						'price_total',
						'created_by',
						'last_updated_by',
					],
					'integer'
				],
				[
					[
						'created_at',
						'last_updated_at',
					],
					'safe'
				],
				[
					[
						'customer_id',
						'price_total',
						'created_by',
						'last_updated_by',
					],
					'required'
				],
			]
		);
	}
}
