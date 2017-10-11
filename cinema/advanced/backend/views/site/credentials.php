<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Cambiar Contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="credentials-form">
<h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($passwordModel, 'oldPassword')->passwordInput(['maxlength' => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($passwordModel, 'newPassword')->passwordInput(['maxlength' => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($passwordModel, 'confirmPassword')->passwordInput(['maxlength' => true]) ?>
                </div>
              </div>
              <div class="form-group">
                  <?= Html::submitButton('Cambiar contraseña', ['class' => 'btn btn-success']) ?>
              </div>
              <?php $form = ActiveForm::end(); ?>

</div>
