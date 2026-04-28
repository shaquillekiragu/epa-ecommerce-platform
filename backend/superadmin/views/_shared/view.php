<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

?>

<main class="d-flex flex-column gap-4 my-5">
	<?php $pk = $model->getPrimaryKey(); ?>

	<section class="d-flex justify-content-end gap-3">
		<?= Html::a(
			'Update',
			['update', 'id' => $pk],
			['class' => 'btn btn btn-outline-warning']
		); ?>

		<?= Html::a(
			'Delete',
			['delete', 'id' => $pk],
			[
				'class' => 'btn btn btn-outline-danger',
				'data' => [
					'confirm' => 'Are you sure you want to delete this record?',
					'method' => 'post',
				],
			]
		); ?>
	</section>

	<?php
	
	$mask_secret_for_display = static function (?string $value): ?string {
		if ($value === null || $value === '') {
			return $value;
		}

		return '****************';
	};

	$attributes = $model->attributes();

	foreach ($attributes as $i => $attribute) {
		if ($attribute !== 'hashed_password') {
			continue;
		}

		$attributes[$i] = [
			'attribute' => 'hashed_password',
			'label' => $model->getAttributeLabel('hashed_password'),
			'value' => $mask_secret_for_display($model->hashed_password ?? null),
		];
		break;
	}
	
	?>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => $attributes,
	]); ?>
</main>
