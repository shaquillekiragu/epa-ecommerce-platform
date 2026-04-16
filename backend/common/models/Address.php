<?php

namespace common\models;

use \common\models\BaseModel;

class Address extends BaseModel {
	public $address_id_list;

	public static function tableName() {
		return 'address';
	}

	public function rules() {
		return array_merge(
			parent::rules(), [
				[
					[
						'address_type',
					],
					'in',
					'range' => ['shipping', 'billing']
				],
				[
					[
						'building_number',
						'street_name',
						'city',
						'region',
						'country',
						'post_code',
					],
					'string',
					'max' => 255
				],
				[
					[
						'created_at',
						'last_updated_at'
					],
					'safe'
				],
				[
					[
						'created_by',
						'last_updated_by'
					],
					'integer'
				],
				[
					[
						'address_type',
						'building_number',
						'street_name',
						'city',
						'country',
						'post_code',
						'created_by',
						'last_updated_by',
					],
					'required'
				],
			]
		);
	}

	// attribute labels method
	// beforeValidate for audit columns
}
