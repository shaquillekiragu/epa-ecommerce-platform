<?php

namespace common\models;

use \common\models\BaseModel;

class Store extends BaseModel {
	public $store_id_list;

	public static function tableName() {
		return 'store';
	}

	public function rules() {
		return array_merge(
			parent::rules(), [
				[
					[
						'store_name',
						'store_description',
					],
					'string',
					'max' => 255
				],
				[
					[
						'merchant_id',
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
						'store_name',
						'store_description',
						'merchant_id',
						'created_by',
						'last_updated_by',
					],
					'required'
				],
				[
					[
						'store_name'
					],
					'unique'
				],
				[
					[
						'store_description'
					],
					'unique'
				],
			]
		);
	}
}
