<?php

/**
 * Shared login form used by multiple backend apps.
 *
 * @var yii\web\View $this
 * @var yii\bootstrap5\ActiveForm $form
 * @var \common\models\LoginForm $model
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'remember_me')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

<?php ActiveForm::end(); ?>
