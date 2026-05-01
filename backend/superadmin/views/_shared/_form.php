<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$attributes = $model->attributes();

$skip_fields = [
	'id',
	'deactivated_at',
	'placed_at',

	'created_at',
	'created_by',
	'last_updated_at',
	'last_updated_by',

	'customer_id',
	'merchant_id',
	'store_id',
	'user_id',
	'address_id',
	'product_id',
	'basket_id',
	'order_id',
	'product_category_id',
];

$boolean_fields = ['allow_update', 'allow_delete'];

$dropdown_fields = ['role', 'is_active', 'address_type', 'status'];

$dropdown_options = [
	'role' => [
		'customer' => 'Customer',
		'merchant' => 'Merchant',
	],
	'is_active' => [
		1 => 'Active',
		0 => 'Inactive',
	],
	'address_type' => [
		'shipping' => 'Shipping',
		'billing' => 'Billing',
		'both' => 'Both',
	],
	'status' => [
		'pending_payment' => 'Pending payment',
		'payment_failed' => 'Payment failed',
		'paid' => 'Paid',
		'shipped' => 'Shipped',
		'delivered' => 'Delivered',
		'cancelled' => 'Cancelled',
		'refunded' => 'Refunded',
	],
];

$date_fields = ['date_of_birth'];
$datetime_fields = [];

$integer_fields = [
	'quantity',
	'number_in_stock',
	'weight_in_grams',
	'price_total',
];

$decimal_fields = [
	'price_in_gbp',
	'price_at_purchase_in_gbp',
];

$textarea_fields = [
	'description',
];

$password_fields = [
	'hashed_password',
];

$email_fields = [
	'email',
];

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row g-3">
	<?php foreach ($attributes as $attribute): 
		if (in_array($attribute, $skip_fields, true)) {
			continue;
		} ?>

		<div class="col-12 col-md-6">
			<?php
			$field = $form->field($model, $attribute);

			switch (true) {
				case in_array($attribute, $boolean_fields, true):
					echo $field->checkbox();
					break;

				case in_array($attribute, $dropdown_fields, true):
					$options = $dropdown_options[$attribute] ?? [];
					echo $field->dropDownList($options, ['prompt' => 'Select...']);
					break;

				case in_array($attribute, $date_fields, true):
					echo $field->input('date');
					break;

				case in_array($attribute, $datetime_fields, true):
					echo $field->input('datetime-local');
					break;

				case in_array($attribute, $integer_fields, true):
					echo $field->input('number', ['step' => 1]);
					break;

				case in_array($attribute, $decimal_fields, true):
					echo $field->input('number', ['step' => '0.01']);
					break;

				case in_array($attribute, $textarea_fields, true):
					echo $field->textarea(['rows' => 4]);
					break;

				case in_array($attribute, $password_fields, true):
					echo $field->passwordInput();
					break;

				case in_array($attribute, $email_fields, true):
					echo $field->input('email');
					break;

				default:
					echo $field;
					break;
			}
			?>
		</div>
	<?php endforeach; ?>
</div>

<div class="mt-4 d-flex justify-content-center gap-2">
	<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
