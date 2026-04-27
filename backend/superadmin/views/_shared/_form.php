<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$attributes = $model->attributes();
$skip = ['id', 'created_at', 'created_by', 'last_updated_at', 'last_updated_by'];

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row g-3">
	<?php foreach ($attributes as $attribute): 
		if (in_array($attribute, $skip, true)) {
			continue;
		} ?>

		<div class="col-12 col-md-6">
			<?= $form->field($model, $attribute) ?>
		</div>
	<?php endforeach; ?>
</div>

<div class="mt-4 d-flex gap-2">
	<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
