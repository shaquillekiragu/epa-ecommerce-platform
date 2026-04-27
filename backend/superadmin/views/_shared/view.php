<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

?>

<main class="d-flex flex-column gap-5 my-5">
	<?= DetailView::widget([
		'model' => $model,
		'attributes' => $model->attributes(),
	]); ?>

	<?php $pk = $model->getPrimaryKey(); ?>

	<section class="d-flex justify-content-between">
		<?= Html::a(
			'Update',
			['update', 'id' => $pk],
			['class' => 'btn btn-outline-warning']
		); ?>

		<?= Html::a(
			'Delete',
			['delete', 'id' => $pk],
			[
				'class' => 'btn btn-outline-danger',
				'data' => [
					'confirm' => 'Are you sure you want to delete this record?',
					'method' => 'post',
				],
			]
		); ?>
	</section>
</main>
