<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Inicio de sesion';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p> Introduce tus datos de usuario para acceder al sitio:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="margin:1em 0">
                    <?= Html::a('Recuperar contraseña', ['site/request-password-reset'], ['class' => 'recover-password']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Iniciar sesion', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="site-logo">We ❤ Movies</div>
</div>
