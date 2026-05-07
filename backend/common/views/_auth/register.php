<?php

/**
 * Shared register view template (web UI).
 *
 * Note: Your API registration currently lives in `api/controllers/AuthController::actionRegister`.
 * This template is here if you later add a web registration flow.
 *
 * @var yii\web\View $this
 * @var \common\models\User $model
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Register';

?>

<div class="site-register">
    <div class="mt-5 offset-lg-3 col-lg-6">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Create an account.</p>

        <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

            <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'last_name')->textInput() ?>
            <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
            <?= $form->field($model, 'password')->passwordInput()->hint('Min 8 chars, at least 1 letter and 1 number.') ?>

            <div class="form-group">
                <?= Html::submitButton('Register', ['class' => 'btn btn-success btn-block']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
