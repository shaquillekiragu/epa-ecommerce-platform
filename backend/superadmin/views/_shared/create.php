<?php

use yii\bootstrap5\Html;

$this->title = 'Create';

?>

<main class="my-5">
	<div class="d-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0"><?= Html::encode($this->title) ?></h1>
	</div>

	<?= $this->render('_form', ['model' => $model]) ?>
</main>
