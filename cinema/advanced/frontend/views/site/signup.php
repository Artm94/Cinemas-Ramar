<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registro de usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Complete los siguientes campos para registrarse en el sitio:</p>

    <div class="row" id="form-cover">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($profile, 'nombres')->textInput(['autofocus' => true]) ?>

                <?= $form->field($profile, 'apellidos')->textInput(['autofocus' => true]) ?>

                <?= $form->field($profile, 'telefono')->textInput(['autofocus' => 10]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Registrarse', ['class' => 'btn btn-default', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
