<?php

use yii\widgets\DetailView;

?>

<main class="my-5">
	<?= DetailView::widget([
		'model' => $model,
		'attributes' => $model->attributes(),
	]); ?>
</main>
