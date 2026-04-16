<?php

namespace common\models;

use \common\models\BaseModel;

class Order extends BaseModel {
	public $order_id_list;

	public static function tableName() {
		return 'order';
	}

	public function rules() {
		return array_merge(
			parent::rules(), [
				[
					[
						'customer_id',
						'store_id',
						'price_total',
						'created_by',
						'last_updated_by',
					],
					'integer'
				],
				[
					[
						'order_datetime',
						'created_at',
						'last_updated_at',
					],
					'safe'
				],
				[
					[
						'status',
					],
					'in',
					'range' => [
						'pending_payment',
						'payment_failed',
						'paid',
						'shipped',
						'delivered',
						'cancelled',
						'refunded'
					]
				],
				[
					[
						'customer_id',
						'store_id',
						'price_total',
						'order_datetime',
						'status',
						'created_by',
						'last_updated_by',
					],
					'required'
				],
			]
		);
	}
}
