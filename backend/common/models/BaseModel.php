<?php

namespace common\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord {
	public function rules() {
		return array_merge(
			parent::rules(), [
				[
					[
						'id'
					],
					'integer'
				],
				[
					[
						'id',
					],
					'required'
				],
			]
		);
	}

	// all the common columns should be here
	// rules
	// attributes
}
