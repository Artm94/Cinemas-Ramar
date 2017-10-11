<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Actualizar información de perfil';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="credentials-form">

<?php $form = ActiveForm::begin(['id' => $profile->formName(), 'options' => ['enctype' => 'multipart/form-data']]); ?>

<h1><?= Html::encode($this->title) ?></h1>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'nombres')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'apellidos')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'telefono')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'file')->fileInput() ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="form-group">
                      <?= Html::submitButton('Actualizar informacion', ['class' => 'btn btn-success']) ?>
                  </div>
                  <?php $form = ActiveForm::end(); ?>

</div>