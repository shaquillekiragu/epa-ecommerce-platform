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
			['class' => 'btn btn-lg btn-outline-warning']
		); ?>

		<?= Html::a(
			'Delete',
			['delete', 'id' => $pk],
			[
				'class' => 'btn btn-lg btn-outline-danger',
				'data' => [
					'confirm' => 'Are you sure you want to delete this record?',
					'method' => 'post',
				],
			]
		); ?>
	</section>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => $model->attributes(),
	]); ?>
</main>
